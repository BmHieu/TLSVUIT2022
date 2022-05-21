(function (Main) {
    Main.baseUrl = '/tlsv2019';
    Main.counter = Main.DEFAULT_COUNTER;
    Main.intervalCountdown = false;
    Main.tickingSound = new Audio(Main.baseUrl + '/assets/sounds/ticking.mp3');
    Main.endSound = new Audio(Main.baseUrl + '/assets/sounds/endsound.mp3');
    Main.magicSound = new Audio(Main.baseUrl + '/assets/sounds/magic.mp3');
    Main.questionBox = 1;
    Main.picker = 'doia';

    Main.teamData = {
        doia: {
            score: 0
        },
        doib: {
            score: 0
        },
        doic: {
            score: 0
        },
        doid: {
            score: 0
        },
        doie: {
            score: 0
        },
        doif: {
            score: 0
        }
    };

    Main.packIndex = 40;
    Main.questionIndex = 0;
    Main.questions = [];
    Main.question = {};
    Main.star_enable = false;

    Main.ableToDoNextStep = false;
    Main.currentStep = 0;
    Main.steps = [];
    Main.init = function () {
        Main.checkKeyDown();
        Main.addListenSubmitEvent();

        Main.steps = [
            Main.showQuestion,
            Main.showChoices,
            Main.showTeamChoice,
            Main.showResult,
            Main.showTotalScore
        ];

        Main.loadQuestions();
    };

    Main.hasStarted = false;
    Main.hideStartup = function () {
        if (!Main.hasStarted) {
            Main.hasStarted = true;
            $('#startup').hide();
        }
    };

    Main.loadQuestions = function () {
        var request = $.ajax({
            url: 'server/questions.php',
            method: 'POST',
            data: {
                packIndex: Main.packIndex,
                questionBox: Main.questionBox
            },
            dataType: 'json'
        });

        request.done(function (data) {
            if (data.error) {
                alert(data.error);
                return;
            }
            Main.questions = data.data
            Main.showQuestionList()
        });
    };

    Main.showQuestionList = function () {
        $('.question-list li').remove()
        var list = $('.question-list');
        for (var i = 0; i < Main.questions.length; i++) {
            var item = $('<li />');
            item.html(i + 1);
            item.appendTo(list);
        }
    };

    Main.showQuestion = function () {
        $('#startup').hide();
        var question = Main.question;
        if (!question) {
            return;
        }

        var container = $('#question-content');
        container.find('.question').html(question.question);
    };

    Main.showChoices = function () {
        var container = $('#question-content');
        var list = container.find('.answers');

        var answers = Main.question.answers;
        for (var i = 0; i < answers.length; i++) {
            var item = $('<li/>');
            item.html(answers[i]);
            item.appendTo(list);
        }

        Main.startCountdown();
        Main.checkTeamChoiceInterval = setInterval(Main.checkTeamChoice, 500);
    };


    Main.checkTeamChoiceInterval = false;
    Main.isCheckingTeamChoice = false;
    Main.choiceMapping = ['A', 'B', 'C', 'D'];
    Main.checkTeamChoice = function () {
        if (Main.isCheckingTeamChoice) {
            return;
        }
        Main.isCheckingTeamChoice = true;

        var request = $.ajax({
            url: 'server/check.php',
            method: 'GET',
            data: {},
            dataType: 'json'
        });

        request.done(function (data) {
            Main.isCheckingTeamChoice = false;
            Main.showCheckingResult(data.data);
        });
    };

    Main.showCheckingResult = function (data) {
        var resultList = $('#result-list');
        var items = resultList.find('li');
        for (var i = 0; i < data.length; i++) {
            var item = $(items[i]);
            item.removeClass();
            item.addClass(data[i].username);
            item.attr('data-choice', data[i].answer).attr('data-text', data[i].username);
            item.find('.team-name').html(data[i].fullname);
        }
    };

    Main.showTeamChoice = function () {
        if (Main.intervalCountdown) {
            Main.currentStep--;
            return;
        }
        var resultList = $('#result-list');
        var items = resultList.find('li');
        items.each(function (index, item) {
            item = $(item);
            if (!item.attr('data-choice')) {
                return;
            }
            if (Main.question.type === 'statement') {
                item.find('.score').html(item.attr('data-choice'));
            } else {
                item.find('.score').html(Main.choiceMapping[item.attr('data-choice')]);
            }
        });
    };

    Main.showResult = function () {
        var answers = $('#question-content .answers');
        var correctIndex = Main.question.correct;
        if (Main.question.type === 'statement') {
            answers.append('<div class="answersStatement correct">' + Main.question.correct + '</div>')
        } else {
            var items = answers.find('li');
            $(items[correctIndex]).addClass('correct');
        }
        $('#result-list li').each(function (index, item) {
            item = $(item);
            var teamname = item.attr('data-text');
            if (teamname) {
                var choice = (parseInt(item.attr('data-choice'))) ? parseInt(item.attr('data-choice')) : item.attr('data-choice');
                if (choice == correctIndex) {
                    var question = Main.question;
                    console.log(teamname, Main.picker, question.score)
                    let score = 0
                    if (teamname === Main.picker){
                        score = question.score
                        if (Main.star_enable) score = score * 2
                    } else {
                        score = question.score / 2
                    }

                    Main.teamData[teamname].score += score;
                    item.find('.score').html(score);
                } else {
                    item.addClass('disabled');
                    item.find('.score').html(0);
                }
            }
        });
    };

    Main.showTotalScore = function (muteSound) {
        for (var index in Main.teamData) {
            if (Main.teamData.hasOwnProperty(index)) {
                $('#score-' + index).html(Main.teamData[index].score);
            }
        }
        if (!muteSound) {
            Main.magicSound.currentTime = 0;
            Main.magicSound.loop = false;
            Main.magicSound.play();
        }
    };

    Main.countdown = function () {
        Main.counter--;
        if (Main.tickingSound.paused) {
            Main.tickingSound.currentTime = 0;
            Main.tickingSound.play();
        }
        if (Main.counter <= 0) {
            Main.stopCountdown();
        }
        $('#countdown').html(Main.counter);
    };

    Main.startCountdown = function () {
        Main.intervalCountdown = setInterval(Main.countdown, 1000);
    };

    Main.stopCountdown = function () {
        clearInterval(Main.intervalCountdown);
        Main.intervalCountdown = false;

        Main.tickingSound.pause();
        Main.endSound.currentTime = 0;
        Main.endSound.play();
        setTimeout(function () {
            Main.endSound.pause();

            clearInterval(Main.checkTeamChoiceInterval);
            Main.checkTeamChoiceInterval = false;
        }, 1500);
    };

    Main.startNewQuestion = function (index, negative) {
        if (!negative) {
            Main.questionIndex = index - 1;
            Main.question = Main.questions[Main.questionIndex]
            if (!Main.question) {
                return;
            }

            Main.hideStartup();
            Main.currentStep = 0;
            Main.ableToDoNextStep = true;

            if (Main.intervalCountdown) {
                Main.stopCountdown();
            }

            Main.counter = Main.question['time'];
            $('#countdown').html(Main.counter);
            Main.setupQuestion();

            var result = $('#result-list');
            result.find('li').each(function (index, item) {
                item = $(item);
                item.removeClass().addClass('default').removeAttr('data-choice').removeAttr('data-text');
                item.find('.team-name').html('');
                item.find('.score').html('');
            });

            //clear team choices
            // var request = $.ajax({
            //     url: 'server/clear-answer.php',
            //     method: 'get',
            //     data: {},
            //     dataType: 'json'
            // });
            //
            // request.done(function (data) {
            //
            // });
        }
    };

    Main.setupQuestion = function () {
        var container = $('#question-content');
        container.find('.question-number').html('Câu hỏi số ' + (Main.questionIndex + 1) + ':');
        $('.question-list li').each(function (index, item) {
            if (index == Main.questionIndex) {
                $(item).addClass('active');
            } else {
                $(item).removeClass('active');
            }
        });

        container.find('.question').html('');
        container.find('.answers').html('');
    };

    Main.selectNextAction = function () {
        if (!Main.ableToDoNextStep) {
            return;
        }
        Main.ableToDoNextStep = false;

        var method = Main.steps[Main.currentStep];
        method();
        setTimeout(function () {
            Main.ableToDoNextStep = true;
            Main.currentStep++;
            if (Main.currentStep >= Main.steps.length) {
                Main.currentStep = 0;
                Main.ableToDoNextStep = false;
            }
        }, 1000);
    };

    Main.checkKeyDown = function () {
        $(window).keydown(function (e) {
            //enter = 13; space = 32; 1 = 49; 2 = 50; 3 = 51; 4 = 52; 5 = 53
            var code = e.keyCode;
            switch (code) {
                case 13:
                    Main.selectNextAction();
                    break;
                case 32:
                    Main.switchScreen();
                    break;
                case 48:
                    Main.chooseStar();
                    break;
                case 49:
                    Main.startNewQuestion(1);
                    break;
                case 50:
                    Main.startNewQuestion(2);
                    break;
                case 51:
                    Main.startNewQuestion(3);
                    break;
                case 52:
                    Main.startNewQuestion(4);
                    break;
                case 53:
                    Main.startNewQuestion(5);
                    break;
                case 65: //a
                    Main.updateScoreManual('a', e.shiftKey);
                    break;
                case 66: //b
                    Main.updateScoreManual('b', e.shiftKey);
                    break;
                case 67: //c
                    Main.updateScoreManual('c', e.shiftKey);
                    break;
                case 68: //d
                    Main.updateScoreManual('d', e.shiftKey);
                    break;
                case 69: //e
                    Main.updateScoreManual('e', e.shiftKey);
                    break;
                case 70: //f
                    Main.updateScoreManual('f', e.shiftKey);
                    break;
                default:
                    break;
            }
        });
    };

    Main.updateScoreManual = function (team, negative) {
        if (negative) {
            Main.teamData['doi' + team].score--;
        } else {
            Main.teamData['doi' + team].score++;
        }
        Main.showTotalScore('mute');
    };

    Main.addListenSubmitEvent = function () {
        Object.keys(Main.teamData).map(team => {
            const selector = document.querySelector(".listname .team-name." + team)
            selector.addEventListener('click', () => {
                resetPolygonStyle();
                Main.picker = team;
                document.querySelector(".polygon." + team).setAttribute('style', 'width:160px!important')
            })
        })
    }

    const resetPolygonStyle = function () {
        Object.keys(Main.teamData).map(team => {
            const selector = document.querySelector(".polygon." + team)
            selector.removeAttribute('style')
        })
    }

    const clearContestText = function () {
        $('#startup').show()
        var container = $('#question-content');
        container.find('.question-number').html('');
        container.find('.question').html('');
        container.find('.answers').html('');
    }

    Main.pickQuestion = function (item) {
        item = $(item)
        let boxNum = item.find('.hexagon-box-number')[0]
        let packIndex = item.find('.hexagon-featured-score')[0]
        Main.packIndex = boxNum.innerHTML
        Main.questionBox = packIndex.innerHTML

        Main.loadQuestions()
        Main.switchScreen()
        clearContestText()

        boxNum.remove()
        packIndex.remove()
    }

    Main.switchScreen = function () {
        let box = $('.question-box-picker')
        let contest = $('#contest')
        if (contest.is(":visible")) {
            box.show()
            contest.hide()
        } else {
            box.hide()
            contest.show()
        }
    }

    Main.chooseStar = function() {
        if (Main.star_enable){
            $('.hope-star').hide()
        } else {
            $('.hope-star').show()
        }
        Main.star_enable = !Main.star_enable
    }
})(window.Main = window.Main || {}, jQuery);