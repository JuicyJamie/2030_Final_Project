
function setup() {
    getRandomTest();
    $("#restart").click(function() {
        $("#text-area").html("");
        getRandomTest();
    });
}

function getRandomTest() {
    let rand = Math.floor(Math.random() * 5 + 1);

    $.getJSON("../tests/tests.json", function(data) {
        let testArr = turnIntoArray(data['test' + rand].testText);
        testArr.map(function(word) {
            $("#text-area").append("<span>" + word + " </span>");
        })
    });
}

function turnIntoArray(paragraph) {
    let arr = [];
    let trimmed;
    let lastIndex = 0;
    for (let i = 0; i < paragraph.length; i++) {
        if (paragraph[i] === " ") {
            trimmed = paragraph.slice(lastIndex, i);
            lastIndex = i+1;
            arr.push(trimmed);
        }
        else if (i === paragraph.length - 1) {
            trimmed = paragraph.slice(lastIndex, i+1);
            arr.push(trimmed);
        }
    }
    return arr;
}

