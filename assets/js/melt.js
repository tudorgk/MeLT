
function Poll(pollName,pollDates,schedule){
    this.name = pollName;
    this.data = pollDates;
    this.scheduleID = schedule;
    this.getInfo = getPollInfo;
    this.displayPoll = displayPollInTarget;
    this.generateHeaders = generateHeaders;
    this.generateInputRow = generateInputRow;
    this.addRow = addRowToPoll;
    this.addSubmitButton = addSubmitButton;
    this.attachForm = attachForm;
    this.table = $('<table></table>').addClass('polling-table');
    this.form;
    this.populateTable = populateTableWithData;

    console.log(this.scheduleID);

}

function getPollInfo() {
    return 'Poll name: ' + this.name;
}

function generateHeaders(){
    //addding the header
    var headerRow = $('<tr></tr>').addClass('header-row');
    headerRow.attr({
        height : 40
    });

    $(this.table).append(headerRow);

    //adding user column
    var userHeader = $('<th></th>').addClass('user-header').text("Participant");
    userHeader.attr('style','font-weight: bold; padding-left : 10px; text-align : left');
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
    intervalRow.attr({
       height: 30
    });
    $(this.table).append(intervalRow);
    for (var i = 0; i < this.data.length; i++) {
        //iterating trough intervals
        var date = this.data[i];
        for(var j = 0; j< date['intervals'].length; j++){
            var intervals = $('<th></th>').addClass('intervals').text(this.data[i]['intervals'][j]['name']);
            if(j != date['intervals'].length -1)
                intervals.attr('style', 'border-right-style: dashed');
            intervalRow.append(intervals);
        }
    }
}

function generateInputRow(){
    var inputRow = $('<tr></tr>').addClass('input-row');
    inputRow.attr({id: "input-row-id"});

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
    var row = $('<tr></tr>').addClass('basic-row');
    this.table.append(row);
}

function attachForm(document,targetForm,scheduleID){
    this.form =targetForm;
    $(this.form).submit(function( event ) {

        // Stop form from submitting normally
        event.preventDefault();

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


        var postData=  {
            scheduleID : scheduleID,
            name: userName,
            data : checkboxes
        };
        // Send the data using post
        var posting = $.post( postingUrl, postData
           );

        //clear the inputs
        $(':input',targetForm)
            .not(':button, :submit, :reset, :hidden')
            .val('')
            .removeAttr('checked')
            .removeAttr('selected');

        // Put the results in a div
        posting.done(function( data ) {
            //first we add the user's name in the Participants column
            var row = $('<tr></tr>').addClass('user-row');
            //$('#input-row-id').append(row);
            $(row).insertBefore($('#input-row-id'));

            var userName = $('<td></td>').addClass('user-name').text(postData['name']);
            $(row).append(userName)

            for(var i = 0;i < postData['data'].length; i++){
                //iterating through the checkboxes
                //to see if we put yes or no for the interval
                var attendance = $('<td></td>').addClass('attendance-check');
                if(postData['data'][i]['checkboxValue']){
                    attendance.text("YES");
                }else{
                    attendance.text("NO");
                }
                $(row).append(attendance);
            }



            var response = JSON.parse(data);

            console.log(response);

            generateStatics(document,response['dates'],response['user_votes']);

        });

    })

}

function populateTableWithData(userData){
    var tableData = [];

    //getting user and their intervals
    var iterator = 0;
    var intervals = [];
    while(iterator!=userData.length){
        var userID = userData[iterator]['user_id'];
        var userName = userData[iterator]['firstname'];

        if(userData.length == iterator + 1){
            //it's the last element
            if(userID == userData[iterator - 1]['user_id'])
            {
                //if it's the same with the last
                intervals.push(userData[iterator]['interval_id']);
            }else{
                intervals = [];
                intervals.push(userData[iterator]['interval_id']);
            }

                var userDict = {
                    userID : userID,
                    userName : userName,
                    intervalValues : intervals
                };

                tableData.push(userDict);

                userDict = [];
                intervals = [];
        }else{
            //it's not the last element
            if(userData[iterator + 1]['user_id'] != userID){
                //if the next element is a different user
                intervals.push(userData[iterator]['interval_id']);

                var userDict = {
                    userID : userID,
                    userName : userName,
                    intervalValues : intervals
                };

                tableData.push(userDict);

                userDict = [];
                intervals = [];
            }else{
                //if the next element is the same user add it to the interval list
                intervals.push(userData[iterator]['interval_id']);
            }
        }
        iterator++;
    }

   //we have now the table data
   //we now need to iterate through the users to add them to the table
    for(var i = 0; i<tableData.length; i++){
        //now we are iterating through the intervals
        //because i was lazy and didn't do the user-interval binding properly. O(n^4). BIG NO NO!

        //first we add the user's name in the Participants column
        var row = $('<tr></tr>').addClass('user-row');
        //$('#input-row-id').append(row);
        $(row).insertBefore($('#input-row-id'));

        var userName = $('<td></td>').addClass('user-name').text(tableData[i]['userName']);
        $(row).append(userName);

        for(var j = 0; j <this.data.length; j++ ){
            //iterating through the days
            for (var k = 0; k< this.data[j]['intervals'].length; k++){
                //iterating through the day's interval
                //to see if we put yes or no for the interval
                var attendance = $('<td></td>').addClass('attendance-check');
                var intervalFound = 0;
                for(var l = 0; l< tableData[i].intervalValues.length; l ++){
                    if(this.data[j]['intervals'][k]['id'] == tableData[i].intervalValues[l] ){
                        intervalFound = 1;
                    }
                }
                if(intervalFound){
                //if the interval was found add YES
                    attendance.text("YES");
                }else{
                    attendance.text("NO");
                }
                $(row).append(attendance);
            }
        }
    }
}


