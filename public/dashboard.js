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

    // Filter panel toggle and filtering logic
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

    // wire inputs: on input change apply filters
    const filterInputs = document.querySelectorAll('[data-filter-input]');
    filterInputs.forEach(inp => {
        const section = inp.getAttribute('data-filter-input');
        inp.addEventListener('input', () => applyFilters(section));
    });

    // clear buttons
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
