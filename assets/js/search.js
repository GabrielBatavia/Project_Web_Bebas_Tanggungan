const dummyData = [
    { id: 2341720022, name: "Aryan", jurusan: "Teknik Informatika" },
    { id: 221757213, name: "Gabriel", jurusan: "Teknik Informatika" },
    { id: 232435466, name: "Adil", jurusan: "Teknik Informatika" },
    { id: 233441576, name: "Michele", jurusan: "Teknik Informatika" }
];

function renderResults(data) {
    const resultsContainer = document.getElementById('results');
    resultsContainer.innerHTML = ""; 

    if (data.length === 0) {
        resultsContainer.innerHTML = "<p>No results found</p>";
        return;
    }

    data.forEach(item => {
        const resultDiv = document.createElement('div');
        resultDiv.classList.add('result');
        resultDiv.innerHTML = `<strong>${item.name}</strong> - ${item.jurusan}`;
        resultsContainer.appendChild(resultDiv);
    });
}

function searchDummy() {
    const query = document.getElementById('searchBox').value.toLowerCase();
    const filteredData = dummyData.filter(item =>
        item.name.toLowerCase().includes(query) || 
        item.jurusan.toLowerCase().includes(query)
    );
    renderResults(filteredData);
}

// Menampilkan semua data awal saat halaman dimuat
renderResults(dummyData);
