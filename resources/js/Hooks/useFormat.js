import moment from "moment/moment";

// Formato numerico
export function useNFmt(num, dec = 2) {
    return Number(num).toFixed(dec).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
}

// Formato de Fecha
export function useDFmt(fecha) {
    if (fecha === null)
        return '';
    return moment(fecha).format('DD/MM/YYYY');
}

export function useDBF(fecha) {
    if (fecha === null)
        return '';
    console.log(fecha);
    return moment(fecha).format('YYYY-MM-DD');
}

export function monthName(monthNumber) {
    return moment(monthNumber, 'MM').format('MMMM');
}

export function usePeriodName(p) {
    if (p.id_periodicidad === 1) {
        return 'QUINCENA: ' + p.consec + ' DE ' + p.id_ejercicio;
    }
    else {
        return moment(p.mes, 'MM').format('MMMM').toUpperCase() + ' DE ' + p.id_ejercicio;
    }
}

// FORMAT DATE IN LL
export function useFormatDate(date) {
    if (date === '9999-12-31')
        return 'Actual';
    moment.defaultFormat = 'es-mx';
    return moment(date).format('ll');
}


// FORMAT DATE IN LL
export function useFormatDateTime(date) {
    if (date === '9999-12-31')
        return 'Actual';
    moment.defaultFormat = 'es-mx';
    return moment(date).format('lll');
}

// FORMATEAR NÚMERO
export const useFormatNumber = (importe_autorizado) => {
    const numberFormat = new Intl.NumberFormat('es-MX');
    return numberFormat.format(importe_autorizado);
}

// Limitar texto
export const limitText = (text, size) => {
    if (text.length > size) {
        return text.slice(0, size) + '...';
    }
    return text;
};

export const decimalToPercentage = (decimal) => {
    return `${(decimal * 100)}%`;
};

export function useAbbreviateNumber(num, digits = 1) {
    if (!num) return '0';

    const lookup = [
        { value: 1, symbol: "" },
        { value: 1e3, symbol: " K" },
        { value: 1e6, symbol: " M" },
        { value: 1e9, symbol: " B" },
        { value: 1e12, symbol: " T" },
    ];

    const rx = /\.0+$|(\.[0-9]*[1-9])0+$/;
    var item = lookup.slice().reverse().find(function (item) {
        return num >= item.value;
    });

    return item ? (num / item.value).toFixed(digits).replace(rx, "$1") + item.symbol : "0";
}
