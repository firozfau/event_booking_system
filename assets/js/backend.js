function tableDataSorting(keyword)
{
    let input, filter, tableBody, tr, td_name, td_event_name, td_event_date, td_fees,
            i, td_name_txtValue, td_event_name_txtValue, td_event_date_txtValue,
            td_fees_txtValue;
    let total_amt = 0;

    filter = keyword.toUpperCase();
    tableBody = document.getElementById("eventDataTableTbody");
    tr = tableBody.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td_name = tr[i].getElementsByTagName("td")[1];
        td_event_name = tr[i].getElementsByTagName("td")[2];
        td_event_date = tr[i].getElementsByTagName("td")[3];
        td_fees = tr[i].getElementsByTagName("td")[5];


        if (td_name !== "" || td_event_name !== "" || td_event_date !== "")
        {
            td_name_txtValue = td_name.textContent || td_name.innerText;
            td_event_name_txtValue = td_event_name.textContent 
                    || td_event_name.innerText;
            td_event_date_txtValue = td_event_date.textContent 
                    || td_event_date.innerText;
            td_fees_txtValue = td_fees.textContent || td_fees.innerText;

            if ((td_name_txtValue.toUpperCase().indexOf(filter) > -1) 
                    || (td_event_name_txtValue.toUpperCase().indexOf(filter) > -1) 
                    || (td_event_date_txtValue.toUpperCase().indexOf(filter) > -1))
            {

                tr[i].style.display = "";

                let each_amt = (parseFloat(td_fees_txtValue.trim()) !== NaN) 
                ? parseFloat(td_fees_txtValue.trim()) 
                : 0;
                total_amt = each_amt + total_amt;

            } else {
                tr[i].style.display = "none";
            }
        }

    }

    document.getElementById("total_perticipent_fee").innerHTML = total_amt.toFixed(2);

}

// delete confirmation 
function showDeleteConfirmationModal() {
    var result = confirm("Are you sure you want to proceed?");
    if (result) {
        return true;
    } else {
        return false;
    }
}

// Function to open the modal
function openModal() {
    document.getElementById("loaderModal").style.display = "block";

}

// Function to close the modal
function closeModal() {
    document.getElementById("loaderModal").style.display = "none";
}


function HttpParameterFormatieren(ParameterObject) {
    let Parameter = "";
    for (const [key, value] of Object.entries(ParameterObject)) {
        Parameter += key + "=" + encodeURIComponent(value) + "&";
    }
    Parameter.slice(0, -1);
    return Parameter;
}

function HttpRequestFunction(
        seitenURL,
        CallbackErfolg,
        ParameterObject = {},
        ) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            CallbackErfolg(this.responseText);
        }
        if (this.readyState == 4 && this.status >= 400) {
            CallbackErfolg(this.responseText);
        }
    };
    xhttp.open("POST", seitenURL, true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send(HttpParameterFormatieren(ParameterObject));
}


// Json  all data insert request 
function actionInsertRequest(requestType)
{
    openModal();

    let Parameter = [];
    Parameter.requestType = requestType;
    HttpRequestFunction(
            "backend/actionSaveToDB.php",
            actionInsertRequestSuccess,
            Parameter
            );

}

function actionInsertRequestSuccess(returnData) {

    closeModal();
    let ret = JSON.parse(returnData);

    if (ret.status == 1)
    {
        generateNewTableData(ret.data);

    } else {
        alert(ret.message);
    }

}


function generateNewTableData(data) {

    document.getElementById("eventDataTableTbody").innerHTML = "";
    let total_fee = 0;

    data.forEach(function (element, index, data) {

        document.getElementById("eventDataTableTbody").appendChild(generateTr(element));

        let each_fee = (parseFloat(element.participation_fee) !== NaN) 
        ? parseFloat(element.participation_fee) : 0; 
        total_fee = total_fee + each_fee;


    }); 
    document.getElementById("total_perticipent_fee").innerHTML = total_fee.toFixed(2);
}


// table all data selete request 
function actionDeleteRequest(requestType)
{
    openModal();
    let Parameter = [];
    Parameter.requestType = requestType;
    HttpRequestFunction(
            "backend/actionSaveToDB.php",
            actionDeleteRequestSuccess,
            Parameter
            );
 
}

function actionDeleteRequestSuccess(returnData) {

    closeModal(); 
    let ret = JSON.parse(returnData); 
    if (ret.status == 1)
    {
        document.getElementById("eventDataTableTbody").innerHTML = "";
        document.getElementById("eventDataTableTbody").appendChild(getTrNoDataAvailable());
        document.getElementById("total_perticipent_fee").innerHTML = "0.0";

    } else {
        alert(ret.message);
    }

}

function getTrNoDataAvailable() {

    let tableRow = document.createElement("tr");
    let tableData = document.createElement("td");
    tableData.style.textAlign = "center";

    tableData.colSpan = 6;
    tableData.textContent = "No data available";
    tableRow.appendChild(tableData);

    return tableRow;
}

function generateTr(row_data) {

    let tableRow = document.createElement("tr");
    let perticipent_td = document.createElement("td");
    let event_date = document.createElement("td");
    let event_name = document.createElement("td");
    let emp_name = document.createElement("td");
    let email = document.createElement("td");
    let fee = document.createElement("td");

    perticipent_td.textContent = row_data.participation_id;
    event_date.textContent = row_data.event_date;
    event_name.textContent = row_data.event_name;
    emp_name.textContent = row_data.employee_name;
    email.textContent = row_data.employee_mail;
    fee.textContent = row_data.participation_fee; 
    
    tableRow.appendChild(perticipent_td);
    tableRow.appendChild(event_date);
    tableRow.appendChild(event_name);
    tableRow.appendChild(emp_name);
    tableRow.appendChild(email);
    tableRow.appendChild(fee);


    return tableRow;

}