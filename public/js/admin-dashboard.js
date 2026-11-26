const canvas = document.querySelector('#dashboard-chart');
const chartStage = canvas.parentElement;
const context = canvas.getContext('2d');
const tooltip = chartStage.querySelector('.chart-tooltip');
const emptyState = chartStage.querySelector('.chart-empty');
const chartButtons = [...document.querySelectorAll('[data-chart-series]')];
const { labels, series } = JSON.parse(document.querySelector('#dashboard-chart-data').textContent);
const formatter = new Intl.NumberFormat();
const compactFormatter = new Intl.NumberFormat(undefined, { notation: 'compact', maximumFractionDigits: 1 });
let activeSeries = series.Views ? 'Views' : (series.News ? 'News' : Object.keys(series)[0]);
let chartPoints = [];

function connectPoints(points) {
    points.slice(1).forEach((point, index) => {
        const previous = points[index];
        const middle = (previous.x + point.x) / 2;
        context.bezierCurveTo(middle, previous.y, middle, point.y, point.x, point.y);
    });
}

function chartStep(highest) {
    const unit = 10 ** Math.floor(Math.log10(Math.max(1, highest) / 5));
    const target = highest / 5 / unit;
    return Math.max(1, unit * ([1, 2, 2.5, 5, 10].find(step => step >= target) || 10));
}

function drawChart() {
    const values = series[activeSeries];
    const { clientWidth: width, clientHeight: height } = chartStage;
    tooltip.hidden = true;
    chartPoints = [];

    if (!values || !context || !width || !height) {
        canvas.hidden = true;
        emptyState.hidden = false;
        emptyState.textContent = activeSeries === 'Views'
            ? 'No numeric view counts are available for this period.'
            : 'No activity data is available.';
        return;
    }

    const ratio = window.devicePixelRatio || 1;
    canvas.hidden = false;
    emptyState.hidden = true;
    canvas.width = Math.round(width * ratio);
    canvas.height = Math.round(height * ratio);
    context.setTransform(ratio, 0, 0, ratio, 0, 0);

    const highest = Math.max(...values);
    const step = chartStep(highest);
    const rows = Math.max(4, Math.ceil(highest / step));
    const max = rows * step;
    const left = 51;
    const right = width - 18;
    const top = 10;
    const bottom = height - 30;
    const chartWidth = right - left;
    const chartHeight = bottom - top;

    context.font = '13px Inter, "Segoe UI", system-ui, sans-serif';
    context.fillStyle = '#dedce4';
    context.strokeStyle = '#ffffff0b';
    context.lineWidth = 1;
    context.textBaseline = 'middle';
    context.textAlign = 'right';

    for (let row = 0; row <= rows; row++) {
        const y = bottom - row * chartHeight / rows;
        context.fillText(compactFormatter.format(row * step), left - 10, y);
        context.beginPath();
        context.moveTo(left, y);
        context.lineTo(right, y);
        context.stroke();
    }

    chartPoints = values.map((value, index) => ({
        x: values.length === 1 ? left + chartWidth / 2 : left + index * chartWidth / (values.length - 1),
        y: bottom - value * chartHeight / max,
        value,
        label: labels[index],
    }));
    const first = chartPoints[0];
    const last = chartPoints.at(-1);
    const markCount = Math.max(2, Math.floor(chartWidth / 86) + 1);
    const markIndices = new Set(Array.from({ length: markCount }, (_, index) =>
        Math.round(index * (chartPoints.length - 1) / (markCount - 1))
    ));

    context.textAlign = 'center';
    markIndices.forEach(index => {
        const point = chartPoints[index];
        const labelX = Math.max(left + 10, Math.min(width - 25, point.x));
        context.fillText(point.label, labelX, bottom + 17);
        context.beginPath();
        context.moveTo(point.x, top);
        context.lineTo(point.x, bottom);
        context.stroke();
    });

    if (chartPoints.length > 1) {
        const fill = context.createLinearGradient(0, top, 0, bottom);
        fill.addColorStop(0, '#f72534a8');
        fill.addColorStop(1, '#84152026');
        context.beginPath();
        context.moveTo(first.x, first.y);
        connectPoints(chartPoints);
        context.lineTo(last.x, bottom);
        context.lineTo(first.x, bottom);
        context.closePath();
        context.fillStyle = fill;
        context.fill();

        context.beginPath();
        context.moveTo(first.x, first.y);
        connectPoints(chartPoints);
        context.lineWidth = 3;
        context.strokeStyle = '#ff343d';
        context.shadowBlur = 12;
        context.shadowColor = '#f5222b88';
        context.stroke();
        context.shadowBlur = 0;
    }

    const pointInterval = Math.max(1, Math.ceil(values.length / 30));
    chartPoints.forEach((point, index) => {
        if (index % pointInterval !== 0 && point !== last) {
            return;
        }

        context.beginPath();
        context.arc(point.x, point.y, 3.5, 0, 2 * Math.PI);
        context.fillStyle = '#fff7f7';
        context.strokeStyle = '#ff343d';
        context.lineWidth = 2;
        context.fill();
        context.stroke();
    });

    canvas.setAttribute('aria-label', `${activeSeries} by day. Total: ${formatter.format(values.reduce((sum, value) => sum + value, 0))}.`);
}

function selectSeries(name) {
    activeSeries = name;
    chartButtons.forEach(button => {
        button.setAttribute('aria-pressed', String(button.dataset.chartSeries === name));
    });
    drawChart();
}

chartButtons.forEach(button => {
    button.addEventListener('click', () => selectSeries(button.dataset.chartSeries));
});

canvas.addEventListener('pointermove', event => {
    if (!chartPoints.length) {
        return;
    }

    const position = event.clientX - canvas.getBoundingClientRect().left;
    const point = chartPoints.reduce((closest, current) =>
        Math.abs(current.x - position) < Math.abs(closest.x - position) ? current : closest
    );
    tooltip.textContent = `${point.label} · ${formatter.format(point.value)} ${activeSeries.toLowerCase()}`;
    tooltip.hidden = false;
    const left = Math.max(0, Math.min(point.x - tooltip.offsetWidth / 2, chartStage.clientWidth - tooltip.offsetWidth));
    const top = Math.max(0, point.y - tooltip.offsetHeight - 9);
    tooltip.style.transform = `translate(${left}px, ${top}px)`;
});
canvas.addEventListener('pointerleave', () => {
    tooltip.hidden = true;
});

new ResizeObserver(drawChart).observe(chartStage);
selectSeries(activeSeries);
