import * as htmlToImage from 'html-to-image';

export function useChartExport() {
    const downloadChart = (chartRef, filename = 'chart') => {
        if (!chartRef?.chart) return;

        const link = document.createElement('a');
        link.href = chartRef.chart.toBase64Image();
        link.download = `${filename}-${Date.now()}.png`;
        link.click();
    };

    const printChart = (chartRef, title = 'Reporte') => {
        if (!chartRef?.chart) return;

        const imageBase64 = chartRef.chart.toBase64Image();
        openPrintWindow(imageBase64, title);
    };

    const downloadChartInstance = (chartInstance, filename = 'chart') => {
        if (!chartInstance) return;

        const link = document.createElement('a');
        link.href = chartInstance.toBase64Image();
        link.download = `${filename}-${Date.now()}.png`;
        link.click();
    };

    const printChartInstance = (chartInstance, title = 'Reporte') => {
        if (!chartInstance) return;

        const imageBase64 = chartInstance.toBase64Image();
        openPrintWindow(imageBase64, title);
    };

    const htmlToImageOptions = {
        cacheBust: true,
        backgroundColor: '#ffffff',
        skipFonts: true,
        preferredFontFormat: '',
        filter: (node) => {
            if (node.tagName === 'LINK' && node.rel === 'stylesheet') {
                return false;
            }
            return true;
        },
    };

    const downloadElement = async (element, filename = 'element') => {
        if (!element) return;

        try {
            const dataUrl = await htmlToImage.toPng(element, htmlToImageOptions);

            const link = document.createElement('a');
            link.href = dataUrl;
            link.download = `${filename}-${Date.now()}.png`;
            link.click();
        } catch (error) {
            console.error('Error al exportar elemento:', error);
        }
    };

    const printElement = async (element, title = 'Reporte') => {
        if (!element) return;

        try {
            const dataUrl = await htmlToImage.toPng(element, htmlToImageOptions);
            openPrintWindow(dataUrl, title);
        } catch (error) {
            console.error('Error al imprimir elemento:', error);
        }
    };

    const openPrintWindow = (imageBase64, title) => {
        const printWindow = window.open('', '_blank');
        if (!printWindow) return;

        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
                <head>
                    <title>Reporte - ${title}</title>
                    <style>
                        body { 
                            text-align: center; 
                            padding: 20px; 
                            font-family: system-ui, sans-serif; 
                        }
                        img { max-width: 100%; height: auto; }
                        h2 { margin-bottom: 1rem; }
                    </style>
                </head>
                <body>
                    <h2>${title}</h2>
                    <img src="${imageBase64}" onload="window.print(); setTimeout(window.close, 500);" />
                </body>
            </html>
        `);
        printWindow.document.close();
    };

    return {
        downloadChart,
        printChart,
        downloadChartInstance,
        printChartInstance,
        downloadElement,
        printElement,
    };
}