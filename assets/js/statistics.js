/**
 * Created by Tudor on 12/11/13.
 */
function generateStatics(target,dates,user_votes){

    //manipulating the data
    console.log(target);
    console.log(dates);
    console.log(user_votes);

    var chartData = [];
    var iter = 0;
    //again... i'm doing the O(n^4) thing... calculating the statistics
    for (var i = 0 ; i<dates.length; i++){
        for (var j = 0; j<dates[i]['intervals'].length; j++){

            var counter = 0;
            for(var k = 0; k<user_votes.length;k++){
                if(user_votes[k]['interval_id'] == dates[i]['intervals'][j]['id'])
                    counter++;
            }

            var dict = {
                date : dates[i]['date'],
                interval : dates[i]['intervals'][j]['name'],
                value: counter
            }

            chartData[iter] = dict;

            iter++;
        }
    }

    console.log(chartData);
    var chartLabels = [];
    var chartDataSets = [];
    var max = 0;
    for(var i = 0; i<chartData.length; i++){
        if (max < chartData[i]['value']){
            max = chartData[i]['value'];
        }
        chartLabels[i] = chartData[i]['date'] + " " + chartData[i]['interval'] ;
        chartDataSets[i] = chartData[i]['value'];
    }

    var barChartData = {
        labels : chartLabels,
        datasets : [
            {
                fillColor : "rgba(151,187,205,0.5)",
                strokeColor : "rgba(151,187,205,1)",
                data : chartDataSets
            }
        ]

    }

    var options ={
        scaleOverlay:false,
        scaleOverride: true,
        scaleSteps: 1,
        scaleStepWidth: max,
        scaleStartValue: 0
    }

    var myLine = new Chart(target.getElementById("canvas").getContext("2d")).Bar(barChartData,options);
}