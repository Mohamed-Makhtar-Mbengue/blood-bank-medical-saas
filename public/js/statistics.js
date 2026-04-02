document.addEventListener("DOMContentLoaded", () => {

    // Données injectées depuis Blade
    const stockByType = JSON.parse(`@json($stockByType)`);
    const statusCounts = JSON.parse(`@json($statusCounts)`);
    const donationsByMonth = JSON.parse(`@json($donationsByMonth)`);
    const emergenciesByMonth = JSON.parse(`@json($emergenciesByMonth)`);

    // Chart 1 : Stock par groupe sanguin
    new ApexCharts(document.querySelector("#chartBloodType"), {
        chart: { type: "donut" },
        series: stockByType.map(x => x.total),
        labels: stockByType.map(x => x.blood_type),
    }).render();

    // Chart 2 : Statuts
    new ApexCharts(document.querySelector("#chartStatus"), {
        chart: { type: "bar" },
        series: [{
            name: "Poches",
            data: statusCounts.map(x => x.total)
        }],
        xaxis: {
            categories: statusCounts.map(x => x.status)
        }
    }).render();

    // Chart 3 : Dons par mois
    new ApexCharts(document.querySelector("#chartDonations"), {
        chart: { type: "line" },
        series: [{
            name: "Dons",
            data: donationsByMonth.map(x => x.total)
        }],
        xaxis: {
            categories: donationsByMonth.map(x => x.month)
        }
    }).render();

    // Chart 4 : Urgences par mois
    new ApexCharts(document.querySelector("#chartEmergencies"), {
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
