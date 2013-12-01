
function Poll(pollName,pollDates){
    this.name = pollName;
    this.data = pollDates;
    this.getInfo = getPollInfo;
    this.displayPoll = displayPollInTarget;
    this.generateHeaders = generateHeaders;
    this.generateInputRow = generateInputRow;
    this.addRow = addRowToPoll;
    this.table = $('<table></table>').addClass('polling-table');
}

function getPollInfo() {
    return 'Poll name: ' + this.name;
}



function generateHeaders(){
    //addding the header
    var headerRow = $('<tr></tr>').addClass('header-row');
    $(this.table).append(headerRow);

    //adding user column
    var userHeader = $('<th></th>').addClass('user-header').text("Participant");
    userHeader.attr('rowspan','2');
    headerRow.append(userHeader);

    //iterating trough dates
    for (var i = 0; i < this.data.length; i++) {
        var header = $('<th></th>').addClass('header-dates').text(this.data[i]['date']);
        header.attr('scope','col');
        header.attr('colspan',this.data[i]['intervals'].length);
        headerRow.append(header);
    }

    //adding the interval header row
    var intervalRow = $('<tr></tr>').addClass('interval-row');
    $(this.table).append(intervalRow);
    for (var i = 0; i < this.data.length; i++) {
        //iterating trough intervals
        var date = this.data[i];
        console.log(date['intervals']);
        for(var j = 0; j< date['intervals'].length; j++){
            var intervals = $('<th></th>').addClass('intervals').text(this.data[i]['intervals'][j]['name']);
            intervalRow.append(intervals);
        }
    }
}

function generateInputRow(){
    var inputRow = $('<tr></tr>').addClass('input-row');
    $(this.table).append(inputRow);

    //add the name input field cell
    var inputCell = $('<td></td>');
    inputRow.append(inputCell);

    //add the input field to the cell
    var inputField = $('<input required>');
    inputField.attr({
        type : "input",
        name : "user",
        placeholder : "Name"
    });
    inputCell.append(inputField);

    //creating checkboxes for every interval
    for (var i = 0; i < this.data.length; i++) {
        //iterating trough intervals
        var date = this.data[i];
        for(var j = 0; j< date['intervals'].length; j++){
            var interval = date['intervals'][j];

            var inputCheckboxCell = $('<td></td>').addClass('input-cell');
            inputRow.append(inputCheckboxCell);

            //creating the checkmark
            var inputCheckbox = $('<input>');
            inputCheckbox.attr({
                type : "checkbox",
                name : 'check-' + date['id'] + '-' + interval['id']
            });
            inputCheckboxCell.append(inputCheckbox);
        }
    }
}

function displayPollInTarget(target){


    this.generateHeaders();

    //add the input row
    this.generateInputRow();

    //adding the table to target
    $(target).append(this.table);
}

function addRowToPoll(){
    console.log('adding row');
    var row = $('<tr></tr>').addClass('basic-row');
    this.table.append(row);
}
