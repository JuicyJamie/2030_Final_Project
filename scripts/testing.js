let started = false;
let correct = 0;
let incorrect = 0;
let keystrokes = 0;

function setup() {
    resetTest();

    $("#restart").click(function() {
        resetTest();
    });

    $("#inputBar").keyup(function(e) {
        keystrokes ++;
        if (e.keyCode != 13 && !started) {
            beginTest();
            console.log(started);
        }
        if (e.keyCode === 32) {
            let entered = $("#inputBar").val();
            let currentWord = $("#text-area").find("span.current").text();
            if (entered === currentWord && $("#text-area").find("span.current").next().length !== 0) {
                $("#text-area").find("span.current").addClass("correct");
                $("#text-area").find("span.current").removeClass("current");
                $("#text-area").find("span.nextWord").addClass("current");
                $("#text-area").find("span.current").next().addClass("nextWord");
                $("#text-area").find("span.current").removeClass("nextWord");
                $("#inputBar").val("");
                correct ++;
            }
            else if (entered !== currentWord && $("#text-area").find("span.current").next().length !== 0) {
                $("#text-area").find("span.current").removeClass("wrong-current");
                $("#text-area").find("span.current").addClass("wrong-previous");
                $("#text-area").find("span.current").removeClass("current");
                $("#text-area").find("span.nextWord").addClass("current");
                $("#text-area").find("span.current").next().addClass("nextWord");
                $("#text-area").find("span.current").removeClass("nextWord");
                $("#inputBar").val("");
                incorrect ++;
            }
        }
        else {
            let typed = $("#inputBar").val();
            let currentWord = $("#text-area").find("span.current").text();
            currentWord = currentWord.substring(0, typed.length);
            if (typed != currentWord) {
                $("#text-area").find("span.current").addClass("wrong-current");
            }
            else {
                $("#text-area").find("span.current").removeClass("wrong-current");
            }

            if ($("#text-area").find("span.current").next().length === 0) {
                if (typed.length === $("#text-area").find("span.current").length && typed.length !== 0) {
                    //grab text from timer div and parse into int
                    //add incorrect words + correct words and then divide by timer to get wpm
                    //divide correct words from total words to get accuracy
                    console.log("correct: " + correct + "\nincorrect: " + incorrect + "\nkeystrokes: " + keystrokes);
                    console.log(typed);
                }
            }
        }
    })
}

function getRandomTest() {
    let rand = Math.floor(Math.random() * 5 + 1);

    $.getJSON("../tests/tests.json", function(data) {
        let testArr = turnIntoArray(data['test' + rand].testText);
        testArr.map(function(word, i) {
            if (i === 0) {
                $("#text-area").append("<span class='first'>" + word + " </span>");
            }
            else {
                $("#text-area").append("<span>" + word + " </span>");
            }
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

function beginTest() {
    // start the timer
    started = true;
    $("#text-area").children("span.first").addClass("current");
    $("#text-area").children("span.first").next().addClass("nextWord");

}

function resetTest() {
    $("#text-area").html("");
    $("#inputBar").val("");
    getRandomTest();
    $("#inputBar").focus();
    //restart timer
    correct = 0;
    incorrect = 0;
    keystrokes = 0;
    started = false;
}

