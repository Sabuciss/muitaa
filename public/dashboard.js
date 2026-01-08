(function(){
    const buttons = document.querySelectorAll('button[data-target]');
    const sections = Array.from(document.querySelectorAll('[data-topic]'));

    function showTopic(topic){
        if(topic === 'all'){
            sections.forEach(s => s.style.display = 'block');
            return;
        }

        sections.forEach(s => {
            if(s.getAttribute('data-topic') === topic){
                s.style.display = 'block';
                s.scrollIntoView({behavior: 'smooth', block: 'start'});
            } else {
                s.style.display = 'none';
            }
        });
    }

    buttons.forEach(b => b.addEventListener('click', function(){
        const t = this.getAttribute('data-target');
        showTopic(t);
    }));

    const filterToggles = document.querySelectorAll('button[data-toggle-filter]');
    filterToggles.forEach(btn => {
        const key = btn.getAttribute('data-toggle-filter');
        btn.addEventListener('click', () => {
            const panel = document.querySelector(`[data-filter-panel="${key}"]`);
            if (!panel) return;
            panel.classList.toggle('hidden');
        });
    });


    const columnMap = {
        vehicles: { plate_no: 2, make: 4, model: 5 },
        users: { username: 2, role: 4 },
        inspections: { type: 3, requested_by: 4 },
        documents: { filename: 3, category: 5, uploaded_by: 7 },
        cases: { id: 1, status: 3 },
        parties: { name: 3, country: 6 }
    };

    function applyFilters(section){
        const panel = document.querySelector(`[data-filter-panel="${section}"]`);
        if (!panel) return;
        const inputs = panel.querySelectorAll('[data-filter-input]');
        const criteria = {};
        inputs.forEach(i => {
            const val = i.value && i.value.trim();
            if (val) criteria[i.getAttribute('data-field')] = val.toLowerCase();
        });

        const rows = document.querySelectorAll(`#section-${section} table tbody tr`);
        rows.forEach(row => {
            let visible = true;
            for (const field in criteria){
                const map = columnMap[section] && columnMap[section][field];
                if (!map) continue;
                const cell = row.querySelector(`td:nth-child(${map})`);
                const text = cell ? (cell.textContent || '').toLowerCase() : '';
                if (!text.includes(criteria[field])){
                    visible = false;
                    break;
                }
            }
            row.style.display = visible ? '' : 'none';
        });
    }

    const filterInputs = document.querySelectorAll('[data-filter-input]');
    filterInputs.forEach(inp => {
        const section = inp.getAttribute('data-filter-input');
        inp.addEventListener('input', () => applyFilters(section));
    });

    const clearBtns = document.querySelectorAll('[data-filter-clear]');
    clearBtns.forEach(b => {
        const section = b.getAttribute('data-filter-clear');
        b.addEventListener('click', () => {
            const panel = document.querySelector(`[data-filter-panel="${section}"]`);
            if (!panel) return;
            panel.querySelectorAll('[data-filter-input]').forEach(i => i.value = '');
            applyFilters(section);
        });
    });
})();

function applyFilters() {
    const vehicle = document.getElementById('filter-vehicle').value.toLowerCase();
    const status = document.getElementById('filter-status').value.toLowerCase();
    const priority = document.getElementById('filter-priority').value.toLowerCase();
    const origin = document.getElementById('filter-origin').value.toLowerCase();
    const destination = document.getElementById('filter-destination').value.toLowerCase();

    const rows = document.querySelectorAll('#cases-table tbody tr');
    rows.forEach(row => {
        const vehicleId = row.cells[1]?.textContent.toLowerCase() || '';
        const rowStatus = row.cells[2]?.textContent.toLowerCase() || '';
        const rowPriority = row.cells[3]?.textContent.toLowerCase() || '';
        const rowOrigin = row.cells[4]?.textContent.toLowerCase() || '';
        const rowDestination = row.cells[5]?.textContent.toLowerCase() || '';
  
        const vehicleMatch = !vehicle || vehicleId.includes(vehicle);
        const statusMatch = !status || rowStatus.includes(status);
        const priorityMatch = !priority || rowPriority.includes(priority);
        const originMatch = !origin || rowOrigin.includes(origin);
        const destinationMatch = !destination || rowDestination.includes(destination);

        row.style.display = (vehicleMatch && statusMatch && priorityMatch && originMatch && destinationMatch) ? '' : 'none';
    });
}

function clearFilters() {
    document.getElementById('filter-vehicle').value = '';
    document.getElementById('filter-status').value = '';
    document.getElementById('filter-priority').value = '';
    document.getElementById('filter-origin').value = '';
    document.getElementById('filter-destination').value = '';
    
    const rows = document.querySelectorAll('#cases-table tbody tr');
    rows.forEach(row => row.style.display = '');
}

function applyDocumentFilters() {
    const filename = document.getElementById('filter-doc-filename').value.toLowerCase();
    const category = document.getElementById('filter-doc-category').value.toLowerCase();
    
    const rows = document.querySelectorAll('#documents-table tbody tr');
    rows.forEach(row => {
        const rowFilename = row.cells[2]?.textContent.toLowerCase() || '';
        const rowCategory = row.cells[3]?.textContent.toLowerCase() || '';
        
        const filenameMatch = !filename || rowFilename.includes(filename);
        const categoryMatch = !category || rowCategory.includes(category);
        
        row.style.display = (filenameMatch && categoryMatch) ? '' : 'none';
    });
}

function clearDocumentFilters() {
    document.getElementById('filter-doc-filename').value = '';
    document.getElementById('filter-doc-category').value = '';
    
    const rows = document.querySelectorAll('#documents-table tbody tr');
    rows.forEach(row => row.style.display = '');
}

function applyVehicleFilters() {
    const plate = document.getElementById('filter-veh-plate').value.toLowerCase();
    const make = document.getElementById('filter-veh-make').value.toLowerCase();
    const country = document.getElementById('filter-veh-country').value.toLowerCase();
    
    const rows = document.querySelectorAll('#vehicles-table tbody tr');
    rows.forEach(row => {
        const rowPlate = row.cells[1]?.textContent.toLowerCase() || '';
        const rowMake = row.cells[3]?.textContent.toLowerCase() || '';
        const rowCountry = row.cells[2]?.textContent.toLowerCase() || '';
        
        const plateMatch = !plate || rowPlate.includes(plate);
        const makeMatch = !make || rowMake.includes(make);
        const countryMatch = !country || rowCountry.includes(country);
        
        row.style.display = (plateMatch && makeMatch && countryMatch) ? '' : 'none';
    });
}

function clearVehicleFilters() {
    document.getElementById('filter-veh-plate').value = '';
    document.getElementById('filter-veh-make').value = '';
    document.getElementById('filter-veh-country').value = '';
    
    const rows = document.querySelectorAll('#vehicles-table tbody tr');
    rows.forEach(row => row.style.display = '');
}

function applyPartiesFilters() {
    const name = document.getElementById('filter-par-name').value.toLowerCase();
    const country = document.getElementById('filter-par-country').value.toLowerCase();
    
    const rows = document.querySelectorAll('#parties-table tbody tr');
    rows.forEach(row => {
        const rowName = row.cells[1]?.textContent.toLowerCase() || '';
        const rowCountry = row.cells[3]?.textContent.toLowerCase() || '';
        
        const nameMatch = !name || rowName.includes(name);
        const countryMatch = !country || rowCountry.includes(country);
        
        row.style.display = (nameMatch && countryMatch) ? '' : 'none';
    });
}

function clearPartiesFilters() {
    document.getElementById('filter-par-name').value = '';
    document.getElementById('filter-par-country').value = '';
    
    const rows = document.querySelectorAll('#parties-table tbody tr');
    rows.forEach(row => row.style.display = '');
}

function toggleDocFilter() {
    document.getElementById('doc-filter-panel').classList.toggle('hidden');
}

function toggleVehFilter() {
    document.getElementById('veh-filter-panel').classList.toggle('hidden');
}

function toggleParFilter() {
    document.getElementById('par-filter-panel').classList.toggle('hidden');
}

document.addEventListener('DOMContentLoaded', () => {
    ['filter-doc-filename', 'filter-doc-category'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.addEventListener('input', applyDocumentFilters);
    });

    ['filter-veh-plate', 'filter-veh-make', 'filter-veh-country'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.addEventListener('input', applyVehicleFilters);
    });

    ['filter-par-name', 'filter-par-country'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.addEventListener('input', applyPartiesFilters);
    });

    document.querySelectorAll('button[data-preference]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const pref = btn.getAttribute('data-preference');
            const sections = ['documents', 'inspections', 'cases', 'vehicles'];
            
            sections.forEach(sec => {
                document.getElementById(`section-${sec}-content`).style.display = 'none';
            });

            if (pref === 'all') {
                sections.forEach(sec => {
                    document.getElementById(`section-${sec}-content`).style.display = '';
                });
            } else {
                const section = document.getElementById(`section-${pref}-content`);
                if (section) section.style.display = '';
            }
        });
    });
});
document.querySelectorAll('.run-risk-btn').forEach(btn => {
    btn.addEventListener('click', async function() {
        const inspectionId = this.dataset.inspectionId;
        const url = this.dataset.url;
        const token = document.querySelector('meta[name="csrf-token"]')?.content || '';
        const button = this;
        
        button.disabled = true;
        button.textContent = 'Running...';
        
        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                const riskCell = document.querySelector(`[data-inspection-id="${inspectionId}"]`);
                if (riskCell) {
                    riskCell.textContent = data.rating + '/5';
                }
                const row = button.closest('tr');
                if (row) {
                    const cells = row.querySelectorAll('td');
                    if (cells.length >= 6) {
                        cells[5].textContent = data.risk_flag;
                    }
                }
                
                button.textContent = data.rating + '/5';
                button.style.backgroundColor = '#10b981';
            }
        } catch (error) {
            console.error('Error:', error);
            button.textContent = 'Error';
            button.style.backgroundColor = '#ef4444';
        }
    });
});