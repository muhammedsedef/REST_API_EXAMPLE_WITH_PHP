const tbody = document.getElementById('table-body');

async function funcName(url){
    const response = await fetch(url);
    var response_json = await response.json();
    if(response_json['status'] != 200) console.log(response_json['message'])
    
    response_json['data'].forEach(row => {
        const tr = document.createElement("tr");

        for(const cell in row) {
            const td = document.createElement("td");
            td.textContent = row[cell];
            tr.appendChild(td);
        }
        
        tbody.appendChild(tr);
    });
}
funcName('http://localhost:8080/test_api/api/product/get.php')
