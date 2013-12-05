
function Poll(pollName,pollDates){
    this.name = pollName;
    this.data = pollDates;
    this.getInfo = getPollInfo;
    this.displayPoll = displayPollInTarget;
    this.generateHeaders = generateHeaders;
    this.generateInputRow = generateInputRow;
    this.addRow = addRowToPoll;
    this.addSubmitButton = addSubmitButton;
    this.attachForm = attachForm;
    this.table = $('<table></table>').addClass('polling-table');
    this.form;
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
        id : "user-input-field",
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

function addSubmitButton(target){

    var submitP = $('<p></p>').addClass("submit");
    submitP.attr({
        style: "float:right"
    })
    var submitButton = $('<input>');
    submitButton.attr({
        class : "large button blue evenspaced",
        value : "Save",
        name : "submit",
        type : "submit"
    });

    submitP.append(submitButton);

    $(target).append(submitP);
}

function displayPollInTarget(target){
    this.target = target;

    this.generateHeaders();

    //add the input row
    this.generateInputRow();

    //adding the table to target
    $(target).append(this.table);

    //add submit button
    this.addSubmitButton(target);

}

function addRowToPoll(){
    console.log('adding row');
    var row = $('<tr></tr>').addClass('basic-row');
    this.table.append(row);
}

function attachForm(targetForm){
    this.form =targetForm;
    $(this.form).submit(function( event ) {

        // Stop form from submitting normally
        event.preventDefault();

        console.log(this);
        // Get some values from elements on the page:
        var userName = $(this).find( "input[name=user]" ).val(),
            postingUrl = $(this).attr( "action" );

        var checkboxes = [];

        $(this).find( "input[name^='check-']" ).each(function (index, element) {

            var dict = {
                checkboxID : $(element).attr("name"),
                checkboxValue: $(element).is(':checked')
            }

            checkboxes.push(dict);
        });


        console.log(userName);
        console.log(checkboxes);
        console.log(postingUrl);


        // Send the data using post
        var posting = $.post( postingUrl,
            {
                name: userName,
                data : checkboxes
            });

        // Put the results in a div
        posting.done(function( data ) {
            console.log(data);
        });

    })

}

