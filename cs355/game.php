<?php
if ($_SERVER['HTTPS'] != "on") {
  $url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
  header("Location: $url");
  exit;
}
session_start(); // this NEEDS TO BE AT THE TOP of the page before any output etc
$user_id = $_SESSION['user_id'];

$conn = new mysqli('localhost','root','','cs355');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->prepare("Select * from user where user_id = '$user_id'");

$result->execute();
$result->store_result();
$result->bind_result($id,$nickname,$email,$user,$role);
$result->fetch();

$result = $conn->prepare("Select * from stats where user_id = '$user_id'");
$result->execute();
$result->store_result();
$result->bind_result($u_id,$social,$crypt,$server,$intruder,$score);
$result->fetch();

if($nickname == null){
  session_start();
  $_SESSION['logMessage'] = "An error occured please try logging in again";
  header('Location: http://localhost/cs355/login.php');
}

?>
</html>
<html lang="en">

<head>
    <title>Secure Arcade</title>
    <link href="homepage.css" rel="stylesheet">
    <link href="trivia.css" rel="stylesheet">
    <link href="keyhunter.css" rel="stylesheet">
    <link href="phishingFrenzy.css" rel="stylesheet">
    <link href="datadefenders.css" rel="stylesheet">
    <script defer src="phishingFrenzy.js"></script>
    <script defer src="homepage.js"></script>
    <script defer src="trivia.js"></script>
    <script defer src="keyhunter.js"></script>
    <script defer src="datadefenders.js"></script>
    <title>Secure Arcade</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <div id="homepage" class="homepage">
        <div class="hp_top">
            <div class="header">
                <h1>Secure Arcade</h1>
                <p>Login successfull!!! Welcome
                    <?php echo $nickname; ?>
                </p>
            </div>
            <div class="navbar">
                <a href="logout.php">Log Out</a>
                <a href="logout.php">Save</a>
            </div>
        </div>
        <div class="hp_bottom">
            <div class="hp_gameBTNs">
                <button class="trivia_home_button hp_btn" onclick="playTrivia()"></button>
                <button class="keyHunters_home_button hp_btn" onclick="playkeyHunters()"></button><br>
                <button class="phishingFrenzy_home_button hp_btn" onclick="playPhishingFrenzy()"></button>
                <button class="dataDefenders_home_button hp_btn" onclick="playDataDefenders()"></button>
            </div>
        </div>
    </div>

    <div id="trivia" class="trivia hide">
        <div id="trivia_pracOrRank">
            <div id="trivia_initScreen" class="trivia_initScreen">
                <button id="trivia_prac_btn" class="trivia_prac_btn btn">Practice</button>
                <button id="trivia_ranked_btn" class="trivia_rank_btn btn">Ranked</button>
                <button id="trivia_home_btn" class="trivia_home_btn btn">Home</button>
            </div>

            <div id="trivia_PracByRorT" class="trivia_PracByRorT hide">
                <button id="trivia_PracByR_btn" class="trivia_PracByR_btn btn">Ranked</button>
                <button id="trivia_PracByT_btn" class="trivia_PracByT_btn btn">Topic</button>
            </div>
        </div>

        <div id="trivia_triv" class="trivia_triv hide">
            <div id="trivia_score">
                <div id="trivia_score_rank">
                    <span>Rank:&nbsp;</span>
                    <span id="trivia_user_rank">0</span>
                </div>
                <hr id="trivia_score_hr">

                <span>Question Number: </span>
                <span id="trivia_qnum">0</span>
                <span id="trivia_scoreboard1"></span><br>
                <span>Correct: </span>
                <span id="trivia_total_correct">0</span>
                <span id="trivia_scoreboard2"></span><br>
                <span>Wrong: </span>
                <span id="trivia_total_wrong">0</span>
                <span id="trivia_scoreboard3"></span><br>
                <span>Timer: </span>
                <span id="trivia_timer">0</span>
            </div>

            <div class="trivia_trivia_container">
                <div id="trivia_question_container" class="hide">
                    <div id="trivia_question">Question</div>
                    <hr>

                    <div id="trivia_answer_buttons" class="trivia_btn_grid">
                        <button class="trivia_btn">Answer 1</button>
                        <button class="trivia_btn">Answer 2</button>
                        <button class="trivia_btn">Answer 3</button>
                        <button class="trivia_btn">Answer 4</button>
                    </div>
                </div>

                <div class="trivia_controls">

                    <div id="trivia_scores_container" class="trivia_scores_container hide">
                        <p id="trivia_total_score"></p>
                        <p id="trivia_alg_score"></p>
                    </div>

                    <div id="trivia_rank_select" class="trivia_rank_select hide">
                        <form action="" method="post">
                            <div id="trivia_pracByRForm" class="trivia_pracByRForm hide">
                                <span>
                                    <label id="trivia_rank_label" for="rank">Rank:</label>

                                    <select id="trivia_rank" name="trivia_rank">
                                        <option value="0">1</option>
                                        <option value="1">2</option>
                                        <option value="2">3</option>
                                        <option value="3">4</option>
                                        <option value="4">5</option>
                                        <option value="5">6</option>
                                        <option value="6">7</option>
                                        <option value="7">8</option>
                                        <option value="8">9</option>
                                        <option value="9">10</option>
                                    </select>
                                </span>
                            </div>
                        </form>
                        <form action="" method="post">
                            <div id="trivia_pracByTForm" class="trivia_pracByTForm hide">
                                <span>
                                    <label id="trivia_topic_label" for="topic">Topic:</label>

                                    <select id="trivia_topic" name="trivia_topic">
                                        <option value="Access Control">Access Control</option>
                                        <option value="Authentication">Authentication</option>
                                        <option value="Cryptography">Cryptography</option>
                                        <option value="Network Security">Network Security</option>
                                        <option value="Malware Protection">Malware Protection</option>
                                        <option value="Vulnerabilities">Vulnerabilities</option>
                                        <option value="Risk Management">Risk Management</option>
                                        <option value="Security Compliance">Security Compliance</option>
                                        <option value="Physical Security">Physical Security</option>
                                        <option value="Social Engineering">Social Engineering</option>
                                    </select>
                                </span>
                            </div>
                        </form>
                        <form action="" method="post">
                            <span>
                                <label id="trivia_numPracQuestionsLabel" for="trivia_numPracQuestionsLabel">Number of
                                    Questions:
                                </label>

                                <select id="trivia_numPracQuestions" name="trivia_numPracQuestions_rank">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                    <option value="25">25</option>
                                </select>
                            </span>
                        </form>
                    </div>
                    <button id="trivia_start_btn" class="trivia_start_btn btn">Start</button>
                    <button id="trivia_next_btn" class="trivia_next_btn btn hide">Next</button>
                    <button id="trivia_finish_btn" class="trivia_finish_btn btn hide">Finish</button>
                    <button id="trivia_reset_btn" class="trivia_reset_btn btn hide">Reset</button>
                    <button id="trivia_submitList_btn" class="trivia_submitList_btn btn hide">Submit</button>
                </div>
            </div>

        </div>
    </div>
    <div id="kh" class="kh hide">
        <div id="kh_startScreen" class="kh_startScreen">
            <p id="kh_msg">Key Hunter</p><br>
            <h6>Under Construction</h6>
            <button id="kh_start_btn" class="kh_start_btn btn">Start</button>
            <button id="kh_home_btn" class="kh_next_btn btn">Home</button>
        </div>
        <div id="kh_inGame" class="hide">

            <!-- <div class="kh_numerals">
                1<br>2<br> 3<br> 4<br> 5<br> 6<br> 7<br> 8<br> 9<br> 10<br> 11<br> 12<br> 13<br>
                14<br> 15<br> 16<br> 17<br> 18<br> 19<br> 20<br> 21<br> 22<br> 23<br> 24<br> 25<br>26<br>
            </div>
            <div class="kh_alphabet">
                <span>A&nbsp;&nbsp;&nbsp;</span><span>B&nbsp;&nbsp;&nbsp;</span><span>C&nbsp;&nbsp;&nbsp;</span><span>D&nbsp;&nbsp;</span>
                <span>E&nbsp;&nbsp;&nbsp;</span> <span>F&nbsp;&nbsp;</span> <span>G&nbsp;&nbsp;</span>
                <span>H&nbsp;&nbsp;</span>
                <span>I&nbsp;&nbsp;&nbsp;&nbsp;</span> <span>J&nbsp;&nbsp;</span> <span>K&nbsp;&nbsp;</span>
                <span>L&nbsp;&nbsp;</span>
                <span>M&nbsp;&nbsp;</span> <span>N&nbsp;&nbsp;</span> <span>O&nbsp;&nbsp;</span>
                <span>P&nbsp;&nbsp;</span>
                <span>Q&nbsp;&nbsp;</span> <span>R&nbsp;&nbsp;</span> <span>S&nbsp;&nbsp;</span>
                <span>T&nbsp;&nbsp;&nbsp;</span>
                <span>U&nbsp;&nbsp;</span> <span>V&nbsp;</span> <span>W&nbsp;&nbsp;</span> <span>X&nbsp;&nbsp;</span>
                <span>Y&nbsp;&nbsp;</span> <span>Z&nbsp;&nbsp;</span>
            </div> -->
            <div class="kh_btncontainer">
                <div id="kh_buttons_container"></div>
            </div>

            <div class="kh_table_container">
                <table id="kh_table">
                </table>
            </div>

            <div id="kh_question_container">
                <p id="kh_btnVal">--</p>
                <div id="kh_question">

                </div>
                Timer: <span id="kh_time">05:00</span>
            </div>

            <div id="kh_question_container">
                <p id="kh_btnVal">--</p>
                <div id="kh_question">
                    <p>Prompt:</p>
                    <p id="kh_mdQ1"></p>
                    <!-- <p id="kh_mdQ2"></p>
                    <p id="kh_mdQ3"></p>
                    <p id="kh_mdQ4"></p>
                    <p id="kh_mdQ5"></p> -->
                </div>
                <!-- Timer: <span id="kh_time">05:00</span> -->
            </div>
        </div>
    </div>
    <div id="phishingFrenzy" class="phishingFrenzy hide">
        <div class="pf_emailBackGround">
            <div class="pf_topMostBar">
                <div class="pf_topMostBarEmailDesign">
                    <div class="pf_topMostBarEmailDesignHome">Home&nbsp;</div>
                    <div class="pf_topMostBarEmailDesignView">View</div>
                    <div class="pf_topMostBarEmailDesignHelp">Help</div>
                    <div class="pf_topMostBarEmailDesignMessage">Message</div>
                    <div class="pf_topMostBarEmailDesignInsert">Insert</div>
                    <div class="pf_topMostBarEmailDesignFormatText">Format text</div>
                    <div class="pf_topMostBarEmailDesignOptions">Options</div>
                </div>
                <div class="pf_livesContainer">
                    <div>Lives:</div>
                    <div id="pf_life1" class="pf_life"></div>
                    <div id="pf_life2" class="pf_life"></div>
                    <div id="pf_life3" class="pf_life"></div>
                </div>
            </div>
            <div class="pf_secondTopMostBar"></div>

            <div class="pf_mainSet">
                <div class="pf_leftContainer">
                    <div class="pf_leftLeftEmailDesign">
                        <div class="pf_favorites">
                            <div class="pf_favoritesTopText">&nbsp;&emsp;&#x2304;&ensp; Favorites</div>
                            <div class="pf_favoritesListBox">
                                <div class="pf_favoritesListBoxImg">
                                    <div class="pf_faveimg pf_selectedInbox"><img class="leftEmailDesignImgs"
                                            src="img/inboxSceenshot.png"></div>
                                    <div class="pf_faveimg"><img class="leftEmailDesignImgs" src="img/sentItemsImg.png">
                                    </div>
                                    <div class="pf_faveimg"><img class="leftEmailDesignImgs" src="img/draftsImg.png">
                                    </div>
                                </div>
                                <div class="pf_favoritesListBoxText">
                                    <div class="pf_faveSpace pf_selectedInbox"><b>Inbox</b></div>
                                    <div class="pf_faveSpace">Sent Items</div>
                                    <div class="pf_faveSpace">Drafts</div>
                                    <div class="pf_faveSpace pf_bText">Add Favorite</div>
                                </div>
                            </div>
                        </div>
                        <div class="pf_folders">
                            <div class="pf_foldersTopText">&nbsp;&emsp;&#x2304;&ensp; Folders</div>
                            <div class="pf_foldersListBox">
                                <div class="pf_foldersListBoxImg">
                                    <div class="pf_foldimg"><img class="leftEmailDesignImgs"
                                            src="img/inboxSceenshot.png"></div>
                                    <div class="pf_foldimg"><img class="leftEmailDesignImgs" src="img/draftsImg.png">
                                    </div>
                                    <div class="pf_foldimg"><img class="leftEmailDesignImgs" src="img/sentItemsImg.png">
                                    </div>
                                    <div class="pf_foldimg"><img class="leftEmailDesignImgs"
                                            src="img/deletedItemsImg.png"></div>
                                    <div class="pf_foldimg"><img class="leftEmailDesignImgs" src="img/junkEmail.png">
                                    </div>
                                    <div class="pf_foldimg"><img class="leftEmailDesignImgs" src="img/archiveimg.png">
                                    </div>
                                    <div class="pf_foldimg"><img class="leftEmailDesignImgs" src="img/pf_notes.png">
                                    </div>
                                    <div class="pf_foldimg"><img class="leftEmailDesignImgs" src="img/pf_foldImg.png">
                                    </div>
                                    <div class="pf_foldimg"><img class="leftEmailDesignImgs" src="img/pf_foldImg.png">
                                    </div>
                                </div>
                                <div class="pf_foldersListBoxText">
                                    <div class="pf_foldSpace">Inbox</div>
                                    <div class="pf_foldSpace">Drafts</div>
                                    <div class="pf_foldSpace">Sent Items</div>
                                    <div class="pf_foldSpace">Deleted Items</div>
                                    <div class="pf_foldSpace">Junk Email</div>
                                    <div class="pf_foldSpace">Archive</div>
                                    <div class="pf_foldSpace">Notes</div>
                                    <div class="pf_foldSpace">Conversation His...</div>
                                    <div class="pf_foldSpace">RSS Feeds</div>
                                    <div class="pf_foldSpace pf_bText">Create new folder</div>
                                </div>
                            </div>
                        </div>
                        <div class="pf_folders">
                            <div class="pf_foldersTopText">&nbsp;&emsp;&#x2304;&ensp; Groups</div>
                            <div class="pf_foldersListBox">
                                <div class="pf_foldersListBoxImg">
                                </div>
                                <div class="pf_foldersListBoxText">
                                    <div class="pf_foldSpace pf_bText">Discover groups</div>
                                    <div class="pf_foldSpace pf_bText">Manage groups</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pf_leftInboxWhole">
                        <div class="pf_topEmailDesign">
                            <div class="pf_topEmailDesignTop">
                                <div class="pf_topEmailDesignTopCheck"><img class="pf_check"
                                        src="img/pf_greyCheck2.png"></div>
                                <div class="pf_inboxText">Legitimate Inbox:</div>
                                <div class="pf_topEmailDesignTopFilter"></div>
                            </div>
                            <div class="pf_topEmailDesignBottom"></div>
                        </div>
                        <div class="pf_inboxes">
                            <div class="pf_blueBar"><img class="pf_blueBarimg" src="img/pf_blueBar.png"></div>
                            <div id="pf_legitInbox" class="pf_legitInbox"></div>
                        </div>
                    </div>
                    <div class="pf_scrollDesign"></div>
                </div>
                <div class="pf_middleContainer">
                    <div class="pf_middleWhitespace"></div>
                    <div class="pf_wholeFrom">
                        <div class="pf_sendbtn"><img class="sendImg" src="img/pf_blueSend.png"></div>
                        <div id="pf_addrDisplay" class="pf_addrDisplay">legitOrPhish@lorp.com</div>
                        <div class="fromEnd"><img class="pf_fromEndImg" src="img/pf_fromEndImg.png"></div>
                    </div>
                    <hr class="pf_smallGreyHr">
                    <div class="pf_wholeTimer">
                        <img class="time_scoreImgs" src="img/pf_timeImg.png">
                        <p id="pf_timeDisplay" class="pf_consoleText">60</p>
                    </div>
                    <hr class="pf_smallGreyHr">
                    <div class="pf_wholeScore">
                        <img class="time_scoreImgs" src="img/pf_scoreImg.png">
                        <p id="pf_scoreDisplay" class="pf_consoleText">0</p>
                    </div>
                    <hr class="pf_smallGreyHr">
                    <div class="pf_wholeAddSubject">
                        <span class="pf_subjectText">The Subject:</span><span
                            class="pf_subjectTextResponse">&ensp;Determine if the following email is
                            a phishing scam!</span>
                    </div>
                    <hr class="pf_smallGreyHr">
                    <div class="pf_wholeEmail">
                        <div id="pf_explanContainer" class="pf_explanContainer hide"></div>

                        <div id="pf_difficultySelector" class="pf_difficultySelector">
                            <p id="pf_playerMessage" class="pf_playerMessage">URGENT!!!! Click the link below to
                                adjust your
                                DiFfIcUlTy settings:</p>
                            <button id="pf_easy"
                                class="pf_easy">http://www.easy.com/rll/DyzZxHtqLqI6BBjRp2syzNpl9HP/kc7XRxgz8Sx</button>
                            <button id="pf_medium"
                                class="pf_medium">http://www.medium.com/aHKV4rag4CHcmyShUmO4r7uiZ1RRKu530pGKtO</button>
                            <button id="pf_hard"
                                class="pf_hard">http://www.hard.com/rll/ssfflf3F36jxTkZNribqX97X8r33pcRxM2S/1gv</button>
                            <hr class="pf_smallBlackHr">
                            <button id="pf_home"
                                class="pf_home">http://www.home.com/VzcTOj4ZCsX80q5uMv_4jaNLgwNer8Y1MS7SR5za1X</button><br>
                        </div>

                        <div id="pf_inGame" class="pf_inGame hide">
                            <div class="pf_emailScreen">
                                <div id="pf_emailDisplay" class="pf_emailDisplay"></div>
                                <div class="pf_btnDisplay">
                                    <button id="pf_legitBtn" class="pf_legitBtn">Legitimate</button>
                                    <button id="pf_phishBtn" class="pf_phishBtn">Phishing</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pf_rightContainer">
                    <div class="pf_rightInboxWhole">
                        <div class="pf_topEmailDesign">
                            <div class="pf_topEmailDesignTop">
                                <div class="pf_topEmailDesignTopCheck"><img class="pf_check" src="img/pf_greyfish.png">
                                </div>
                                <div class="pf_inboxText">Phishing Inbox:</div>
                                <div class="pf_topEmailDesignTopFilter"></div>
                            </div>
                            <div class="pf_topEmailDesignBottom"></div>
                        </div>
                        <div class="pf_inboxes">
                            <div class="pf_blueBar"><img class="pf_blueBarimg" src="img/pf_blueBar.png"></div>
                            <div id="pf_phishInbox" class="pf_pishInbox"></div>
                        </div>
                        <div class="pf_rightInbox"></div>
                    </div>
                    <div class="pf_scrollDesign"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="datadefenders" class="datadefenders hide">
        <div class="wholedd">
            <button id="dd_home" class="dd_home reportButton">home</button><span class="lime">
            </span>
            <span><div class="reportButton">Report</div></span><span class="deleteThis">Under Construction!!!!!</span>
            <div class="serverContent">
                <div id="server1" class="server">
                    <div class="serverText">
                        <div class="ipContent">
                            <span class="ipText">IP Connections:</span>
                            <span id="IPServer1" class="inputboxes">192.168.1.0</span>
                        </div>
                        <div class="sysCallsContent">
                            <span class="sysCallsText"># System Calls:</span>
                            <span id="sysCallsServer1" class="inputboxes">0</span>
                        </div>
                        <div class="dataFlow">
                            <span class="ipText">Data Flow:</span>
                            <span id="dataFlowServer1" class="inputboxes">10011101011001</span>
                        </div>
                    </div>
                    <div class="serverhealth">
                        <h1 class="serverTitle">Server 1</h1>
                        <div id="circleServer1" class="circle"></div>
                        <p id="runServer1">running</p>
                    </div>
                    <div class="monitorContent">
                        <div id="logsServer1" class="checkLogs">Check Logs</div>
                        <div id="cameraServer1" class="checkCameras">Check Cameras</div>
                    </div>
                </div>
                <div id="server2" class="server">
                    <div class="serverText">
                        <div class="ipContent">
                            <span class="ipText">IP Connections:</span>
                            <span id="IPServer2" class="inputboxes">192.168.1.0</span>
                        </div>
                        <div class="sysCallsContent">
                            <span class="sysCallsText"># System Calls:</span>
                            <span id="sysCallsServer2" class="inputboxes">0</span>
                        </div>
                        <div class="dataFlow">
                            <span class="ipText">Data Flow:</span>
                            <span id="dataFlowServer2" class="inputboxes">10011101011001</span>
                        </div>
                    </div>
                    <div class="serverhealth">
                        <h1 class="serverTitle">Server 2</h1>
                        <div id="circleServer2" class="circle"></div>
                        <p id="runServer2">running</p>
                    </div>
                    <div class="monitorContent">
                        <div id="logsServer2" class="checkLogs">Check Logs</div>
                        <div id="cameraServer2" class="checkCameras">Check Cameras</div>
                    </div>
                </div>
                <div id="server3" class="server">
                    <div class="serverText">
                        <div class="ipContent">
                            <span class="ipText">IP Connections:</span>
                            <span id="IPServer3" class="inputboxes">192.168.1.0</span>
                        </div>
                        <div class="sysCallsContent">
                            <span class="sysCallsText"># System Calls:</span>
                            <span id="sysCallsServer3" class="inputboxes">0</span>
                        </div>
                        <div class="dataFlow">
                            <span class="ipText">Data Flow:</span>
                            <span id="dataFlowServer3" class="inputboxes">10011101011001</span>
                        </div>
                    </div>
                    <div class="serverhealth">
                        <h1 class="serverTitle">Server 3</h1>
                        <div id="circleServer3" class="circle"></div>
                        <p id="runServer3">running</p>
                    </div>
                    <div class="monitorContent">
                        <div id="logsServer3" class="checkLogs">Check Logs</div>
                        <div id="cameraServer3" class="checkCameras">Check Cameras</div>
                    </div>
                </div>
                <div id="server4" class="server">
                    <div class="serverText">
                        <div class="ipContent">
                            <span class="ipText">IP Connections:</span>
                            <span id="IPServer4" class="inputboxes">192.168.1.0</span>
                        </div>
                        <div class="sysCallsContent">
                            <span class="sysCallsText"># System Calls:</span>
                            <span id="sysCallsServer4" class="inputboxes">0</span>
                        </div>
                        <div class="dataFlow">
                            <span class="ipText">Data Flow:</span>
                            <span id="dataFlowServer4" class="inputboxes">10011101011001</span>
                        </div>
                    </div>
                    <div class="serverhealth">
                        <h1 class="serverTitle">Server 4</h1>
                        <div id="circleServer4" class="circle"></div>
                        <p id="runServer4">running</p>
                    </div>
                    <div class="monitorContent">
                        <div id="logsServer4" class="checkLogs">Check Logs</div>
                        <div id="cameraServer4" class="checkCameras">Check Cameras</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>