// resources/js/api.js

export async function performRequest(url, method = 'GET', data = null) {
    const headers = {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
    };

    const options = {
        method,
        headers,
    };

    if (data && (method !== 'GET' && method !== 'HEAD')) {
        options.body = JSON.stringify(data);
    }

    try {
        const response = await fetch(url, options);

        if (!response.ok) {
            if (response.status === 422) {
                const errorData = await response.json();
                let errorMessages = '';
                for (let field in errorData.errors) {
                    errorMessages += `${errorData.errors[field].join('<br>')}<br>`;
                }
                if (typeof alertify !== 'undefined') {
                    alertify.error(errorMessages || 'Error de validación');
                }
                throw new Error('Validation Error');
            } else {
                if (typeof alertify !== 'undefined') {
                    alertify.error(`Error de servidor: HTTP ${response.status}`);
                }
                throw new Error(`HTTP Error: ${response.status}`);
            }
        }

        return await response.json();
    } catch (error) {
        if (error.message !== 'Validation Error' && !error.message.startsWith('HTTP Error')) {
            if (typeof alertify !== 'undefined') {
                alertify.error('Error de red o conexión perdida.');
            }
        }
        throw error;
    }
}

export function generateRow(item, templateCallback) {
    return templateCallback(item);
}

export function updateTable(containerId, dataList, templateCallback) {
    const container = document.getElementById(containerId);
    if (!container) return;

    container.innerHTML = '';

    if (!dataList || dataList.length === 0) {
        container.innerHTML = `<tr><td colspan="100%" class="text-center p-4">No hay datos disponibles en este momento.</td></tr>`;
        return;
    }

    const htmlContent = dataList.map(item => generateRow(item, templateCallback)).join('');
    container.innerHTML = htmlContent;
}
