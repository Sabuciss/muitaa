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
    const hscode = document.getElementById('filter-hscode').value.toLowerCase();
    const party = document.getElementById('filter-party').value.toLowerCase();
    const status = document.getElementById('filter-status').value.toLowerCase();
    const priority = document.getElementById('filter-priority').value.toLowerCase();
    const origin = document.getElementById('filter-origin').value.toLowerCase();
    const destination = document.getElementById('filter-destination').value.toLowerCase();

    const rows = document.querySelectorAll('#cases-table tbody tr');
    rows.forEach(row => {
        const vehicleId = row.cells[1]?.textContent.toLowerCase() || '';
        const hsCodeText = row.cells[2]?.textContent.toLowerCase() || '';
        const partyText = row.cells[3]?.textContent.toLowerCase() || '';
        const rowStatus = row.cells[4]?.textContent.toLowerCase() || '';
        const rowPriority = row.cells[5]?.textContent.toLowerCase() || '';
        const rowOrigin = row.cells[6]?.textContent.toLowerCase() || '';
        const rowDestination = row.cells[7]?.textContent.toLowerCase() || '';
  
        const vehicleMatch = !vehicle || vehicleId.includes(vehicle);
        const statusMatch = !status || rowStatus.includes(status);
        const priorityMatch = !priority || rowPriority.includes(priority);
        const originMatch = !origin || rowOrigin.includes(origin);
        const destinationMatch = !destination || rowDestination.includes(destination);
        const hscodeMatch = !hscode || hsCodeText.includes(hscode);
        const partyMatch = !party || partyText.includes(party);

        row.style.display = (vehicleMatch && statusMatch && priorityMatch && originMatch && destinationMatch && hscodeMatch && partyMatch) ? '' : 'none';
    });
}

function clearFilters() {
    document.getElementById('filter-vehicle').value = '';
    document.getElementById('filter-hscode').value = '';
    document.getElementById('filter-party').value = '';
    document.getElementById('filter-status').value = '';
    document.getElementById('filter-priority').value = '';
    document.getElementById('filter-origin').value = '';
    document.getElementById('filter-destination').value = '';
    
    const rows = document.querySelectorAll('#cases-table tbody tr');
    rows.forEach(row => row.style.display = '');
}

document.addEventListener('DOMContentLoaded', function() {
    const preferenceButtons = document.querySelectorAll('button[data-preference]');
    
    preferenceButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const preference = this.getAttribute('data-preference');

            document.getElementById('section-documents-content').style.display = 'none';
            document.getElementById('section-inspections-content').style.display = 'none';
            document.getElementById('section-cases-content').style.display = 'none';
            document.getElementById('section-vehicles-content').style.display = 'none';
            
            if (preference === 'all') {
                document.getElementById('section-documents-content').style.display = '';
                document.getElementById('section-inspections-content').style.display = '';
                document.getElementById('section-cases-content').style.display = '';
                document.getElementById('section-vehicles-content').style.display = '';
            } else {
                const sectionId = `section-${preference}-content`;
                const section = document.getElementById(sectionId);
                
                if (section) {
                    section.style.display = '';
                }
            }
        });
    });
});
