document.addEventListener("DOMContentLoaded", () => {

    const emergenciesByType = JSON.parse(`@json($emergenciesByType)`);
    const emergenciesByMonth = JSON.parse(`@json($emergenciesByMonth)`);

    // Graphique 1 : urgences par type
    new ApexCharts(document.querySelector("#chartEmergencyType"), {
        chart: { type: "donut" },
        series: emergenciesByType.map(x => x.total),
        labels: emergenciesByType.map(x => x.emergency_level),
    }).render();

    // Graphique 2 : urgences par mois
    new ApexCharts(document.querySelector("#chartEmergencyMonth"), {
        chart: { type: "line" },
        series: [{
            name: "Urgences",
            data: emergenciesByMonth.map(x => x.total)
        }],
        xaxis: {
            categories: emergenciesByMonth.map(x => x.month)
        }
    }).render();

});
