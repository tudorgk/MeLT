
function Poll(pollName,pollDates){
    this.name = pollName;
    this.data = pollDates;
    this.getInfo = getPollInfo;
    this.displayPoll = displayPollInTarget;
}

function getPollInfo() {
    return 'Poll name: ' + this.name;
}

function displayPollInTarget(target){
    var table = $('<table></table>').addClass('polling-table');

    //addding the header
    var headerRow = $('<tr></tr>').addClass('header-row');
    table.append(headerRow);

    //iterating trough dates
    for (var i = 0; i < this.data.length; i++) {
        var header = $('<th></th>').addClass('header-dates').text(this.data[i]['date']);
        header.attr('scope','col');
        header.attr('colspan',this.data[i]['intervals'].length);
        headerRow.append(header);
    }

    //adding the interval header row
    var intervalRow = $('<tr></tr>').addClass('interval-row');
    table.append(intervalRow);
    for (var i = 0; i < this.data.length; i++) {
        //iterating trough intervals
        var date = this.data[i];
        console.log(date['intervals']);
        for(var j = 0; j< date['intervals'].length; j++){
            var intervals = $('<th></th>').addClass('intervals').text(this.data[i]['intervals'][j]['name']);
            intervalRow.append(intervals);
        }
    }

    //adding the table to target
    $(target).append(table);
}
