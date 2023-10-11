var addedItems = [];
let totalSum = 0;


function addRow(val1, val2, val3, val4, val5, code) {
    // Check if the item already exists in the addedItems array
 
    if (addedItems.includes(val1)) {
        // Item is a duplicate, show an alert
        // alert("Item is a duplicate");
        Swal.fire({
            icon: 'error',
            title: 'คุณเลือกคูปองนี้เเล้ว',
            text: 'ไม่สามารถเลือกคูปองนี้ซ้ำได้',
        });
        return; // Don't add the duplicate item
    }

    // Add the item to the addedItems array
    addedItems.push(val1,val2,val3,val5,val5);
    // addedItems.push({
    //     ordername: val1,
    //     packagecode: val2,
    //     packagepoint: val3,
    //     packagetime: val4
    // })
   
   //document.getElementById('demo').innerHTML = Totapoint;   

    // Get the table body element in which you want to add a row
    let table = document.getElementById("AddCoupou");

    // Create row element
    let row = document.createElement("tr");

    // Create cells
    let c1 = document.createElement("td");
    let c2 = document.createElement("td");
    let c3 = document.createElement("td");
    let c4 = document.createElement("td");
    let c5 = document.createElement("td");

    // Insert data into cells
    c1.innerText = val1;
    c2.innerText = val3;
    c3.innerText = val4;
    c4.innerText = val5;
    c5.innerHTML = '<input type="hidden" name="package[]" value="'+code+'"><input class="btn btn-danger" '+' type="button" value="ลบ" onclick="deleteRow(this)" />';

    // Append cells to the row
    row.appendChild(c1);
    row.appendChild(c2);
    row.appendChild(c3);
    row.appendChild(c4);
    row.appendChild(c5);

    // Append the row to the table body
    table.appendChild(row);
    // Totapoint.push(val4);
    // var Tota = sumArray(Totapoint);
    
    // Calculate the new totalSum
    totalSum += parseFloat(val4);

    // Display the totalSum
    document.getElementById("demo").innerHTML =  totalSum;
    $('#totalPoint').val(totalSum);
}


function sumArray(arr) {
    let total = 0;
    for (let i = 0; i < arr.length; i++) {
      total += arr[i];
    }
    return total;
}
// document.getElementById('demo').innerHTML = sumArray(Totapoint);   


// let date = new Date();
// let testdate = document.getElementById('currentdate').value = date.toLocaleDateString('en-GB')

// console.log(testdate)

function setCurrentDate() {
    var date = new Date();    
    var formattedDate = date.toLocaleDateString('en-GB');
    document.getElementById('currentdate').value = formattedDate;
    console.log(formattedDate);
  }
  // Call the function to set the current date when needed
  setCurrentDate();  

function dataType(){
    var d = new Date();
    
    //var ds = String(d).split("");
    //console.log(ds)
    //console.log(ds[2], ds[1], ds[3])
    var dd = d.setDate(d.getMonth()+1);    
    var formattedDate = d.toLocaleDateString('en-GB');  
    console.log(d)  
    console.log(formattedDate)

    var dd = new Date().getDate();
    var dm = new Date().getMonth()+1;
    var dy = new Date().getFullYear();
    dmm = dm+1;
    console.log(dd,dm,dy)
    console.log('บวก 30 วัน')
    console.log(dd,dmm,dy)
}
//console.log("วันนี้")
//dataType();

function setDateDay() {
    var date = new Date();    
    var formattedDate = date.toLocaleDateString('en-GB');    
    console.log(formattedDate);
    return formattedDate;
  }
  // Call the function to set the current date when needed
 //setDateDay()

function getOneMonthFromToday() {
    var currentDate = new Date();
    
    // Get the current month and year
    var currentMonth = currentDate.getMonth();
    var currentYear = currentDate.getFullYear();
    
    // Calculate the next month
    var nextMonth = currentMonth + 1;
    
    // Check if we need to increment the year
    if (nextMonth > 11) {
      nextMonth = 0; // January (0-based index)
      currentYear++;
    }
    
    // Create a new date for the next month
    var oneMonthFromToday = new Date(currentYear, nextMonth, currentDate.getDate());
    
    var formattedDate = oneMonthFromToday.toLocaleDateString('en-GB');
    console.log(formattedDate);
    return formattedDate;
  }
  
  // Call the function to get the date one month from today
  //var result = getOneMonthFromToday();
  //getOneMonthFromToday();

/* This method will read the table data in json format */
function readTableData() {
    //gets table
    var eTable = document.getElementById('');

    //gets rows of table
    var rowLength = eTable.rows.length;

    var totalEmp = [];
    var headers = [];

    //loops through rows    
    for (i = 0; i < rowLength; i++) {

        //gets cells of current row
        var oCells = eTable.rows.item(i).cells;

        //gets count of cells of current row
        var cellLength = oCells.length;

        var rowData = {};

        //loops through each cell (except last cell) in current row             
        for (var j = 0; j < cellLength - 1; j++) {
            if (i == 0) {
                //reading the table headers
                /* get your cell info here */
                var cellVal = oCells.item(j).innerHTML;
                headers.push(cellVal);
            } else {
                //reading the table data
                var cellVal = oCells.item(j).childNodes[0].value;
                var headerName = headers[j];
                rowData[headerName] = cellVal;
            }

        }
        //skip adding first row (header row) to total record
        if (i != 0) {
            totalEmp.push(rowData);
        }
    }

    document.getElementById("total-data").innerHTML = JSON.stringify(totalEmp);
}

/* This method will delete a row */
function deleteRow(ele) {
    var table = document.getElementById('AddCoupou');
    var rowCount = table.rows.length;
    if (rowCount <= 1) {
        alert("There is no row available to delete!");
        return;
    }
    if (ele) {
        // Get the item name to be removed
        var itemName = ele.parentNode.parentNode.cells[0].innerText;
        var val4 = parseFloat(ele.parentNode.parentNode.cells[2].innerText);

        // Remove the item from the addedItems array
        var index = addedItems.indexOf(itemName);
        if (index !== -1) {
            addedItems.splice(index, 1);
        }
        // Subtract the value of val4 from the totalSum
        totalSum -= val4;

        // Delete the specific row
        ele.parentNode.parentNode.remove();
    } else {
        // Delete the last row
        var lastRow = table.rows[rowCount - 1];
        var itemName = lastRow.cells[0].innerText;
        var val4 = parseFloat(lastRow.cells[2].innerText);

        // Remove the item from the addedItems array
        var index = addedItems.indexOf(itemName);
        if (index !== -1) {
            addedItems.splice(index, 1);
        }
         // Subtract the value of val4 from the totalSum
        totalSum -= val4;
        table.deleteRow(rowCount - 1);
    }
    // Display the updated totalSum
    document.getElementById("demo").innerHTML = totalSum;
}


function fun() {
    document.getElementById("myForm").reset();
}

function Clear() {
    document.getElementById("search_HN").reset();
}

function submitForm(){
    $('#formSubmit').submit();
}

// Define a function to perform the data retrieval
// Define a function to perform the data retrieval
function retrieveData() {
    var hncard = $('input#hncard').val();
    var fullname = $('input#fullname').val();
    var phone = $('input#phone').val();

    // Return a Promise
    return new Promise(function (resolve, reject) {
        //ส่งค่าไป Search_data ด้วย jQuery Ajax
        $.ajax({
            url: 'search_HN',
            type: 'POST',
            dataType: 'json',
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                hncard: hncard,
                fullname: fullname,
                phone: phone
            },
            success: function (data) {
                $('#fullname').val(data.fullname);
                $('#phone').val(data.mobilephone);
                resolve(data); // Resolve the Promise with the retrieved data
            },
            error: function (error) {
                document.getElementById('hncard').value = '';
                document.getElementById('fullname').value = '';
                document.getElementById('phone').value = '';
                // alert('ไม่พบข้อมูล');
                Swal.fire({
                    icon: 'warning',
                    title: 'ไม่พบข้อมูล',
                    text: 'This item cant found in Database!',
                });
                reject(error); // Reject the Promise with an error
            }
        });
    });
}

// Attach the event handler to the input element
$("input").on("keydown", function search(e) {
    if (e.keyCode == 13) {
        retrieveData()
            .then(function (data) {
                console.log(data);
                
            })
            .catch(function (error) {
                console.error(error); // Log any errors
            });
    }
});

function Clear_HN() {
    let output = document.getElementById('output');
    function clearAllInputs(event) {
        var allInputs = document.querySelectorAll('input');
        allInputs.forEach(singleInput => singleInput.value = '');
        output.innerHTML += "Form submitted and cleared successfully! <br>";
    }
}

function clearInput(hncard, fullname, phone) {
    document.getElementById('hncard').value = ''
    document.getElementById('fullname').value = ''
    document.getElementById('phone').value = ''
}




function initializeOrderCounter() {
    let counter = localStorage.getItem('orderCounter');
    if (counter === null) {
      counter = 1;
    } else {
      counter = parseInt(counter, 36); // Parse as base 36 to support letters and numbers
    }
    return counter;
  }
  
  // Function to retrieve and display order numbers in an input field
function displayOrderNumber() {
    const orderInput = document.getElementById('orderno');

    // Retrieve the current order counter from local storage
    let orderCounter = localStorage.getItem('orderCounter');
    if (orderCounter === null) {
        orderCounter = 1;
    } else {
        orderCounter = parseInt(orderCounter, 36);
    }

    // Generate and display the next order number
    const letter = String.fromCharCode(65 + Math.floor(orderCounter / 10000));
    const number = (orderCounter % 10000).toString().padStart(4, '0');
    const orderNumber = `${letter}${number}`;

    // Update the input field value
    orderInput.value = orderNumber;

    // Increment the counter and store it in local storage in base 36
    orderCounter++;
    if (orderCounter >= 260000) { // Stop incrementing when we reach Z9999
        orderCounter = 260000;
    }
    localStorage.setItem('orderCounter', orderCounter.toString(36));
}

// Call the function to display the order number when the page loads
displayOrderNumber();

 





  