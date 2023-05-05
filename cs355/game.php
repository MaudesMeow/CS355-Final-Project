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

$rst = $conn->prepare("Select * from user where user_id = '$user_id'");

$rst->execute();
$rst->store_result();
$rst->bind_result($id,$nickname,$email,$user,$role);
$rst->fetch();

$result = $conn->prepare("Select * from stats where user_id = '$user_id'");
$result->execute();
$result->store_result();
$result->bind_result($u_id,$triviaRank,$keyHunterHighScore,$phishingFrenzyHighScore,$dataDefDay,$dataDefBalance,$dataDefFixes,$dataDefReputation,
$dd_ss1,$dd_hs1,$dd_ss2,$dd_hs2,$dd_ss3,$dd_hs3,$dd_ss4,$dd_hs4);
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
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script defer src="dataDefenders.js"></script>
    <title>Secure Arcade</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <div id="homepage" class="homepage">
        <div class="hp_top">
            <div class="header">
                <h1>SECURE ARCADE</h1>
                <span>Login successfull! Welcome</span>
                <span id="nickname"><?php echo $nickname; ?></span>
            </div>
        </div>
        <div class="navbar">
            <div class="links">
                <a href="logout.php">Log Out</a>
                <form id="saveForm" action="save.php" method="post">
                    <div class="hide">
                        <input type="text" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
                        <input type="number" id="trivRankUpdate" name="trivRankUpdate">
                        <input type="number" id="khHighscoreUpdate" name="khHighscoreUpdate">
                        <input type="number" id="pfHighscoreUpdate" name="pfHighscoreUpdate">
                        <input type="number" id="ddDayUpdate" name="ddDayUpdate">
                        <input type="number" id="ddBalanceUpdate" name="ddBalanceUpdate">
                        <input type="number" id="ddFixUpdate" name="ddFixUpdate">
                        <input type="number" id="ddRepUpdate" name="ddRepUpdate">
                        <input type="number" id="ddSS1Update" name="ddSS1Update">
                        <input type="number" id="ddHS1Update" name="ddHS1Update">
                        <input type="number" id="ddSS2Update" name="ddSS2Update">
                        <input type="number" id="ddHS2Update" name="ddHS2Update">
                        <input type="number" id="ddSS3Update" name="ddSS3Update">
                        <input type="number" id="ddHS3Update" name="ddHS3Update">
                        <input type="number" id="ddSS4Update" name="ddSS4Update">
                        <input type="number" id="ddHS4Update" name="ddHS4Update">
                    </div>
                    <input class="saveBtn" type="submit" id="save" value="Save">        
                </form>
            </div>
        </div>
        <div class="hp_bottom">
            <div class="hp_bottom_container">
                <div class="hp_bottom_left">
                    <div class="hp_table">
                        <table class="scoretable">
                            <tr>
                                <th>Game</th>
                                <th>Score</th>
                            </tr>
                            <tr>
                                <td>Trivia Rank</td>
                                <td id="hs_trivRank"><?php echo $triviaRank; ?></td>
                            </tr>
                            <tr>
                                <td>Key Hunter Score</td>
                                <td id="hs_khHighscore"><?php echo $keyHunterHighScore; ?> </td>
                            </tr>
                            <tr>
                                <td>Phish Frenzy HS</td>
                                <td id="hs_pfHighscore"><?php echo $phishingFrenzyHighScore; ?></td>
                            </tr>
                            <tr>
                                <td>Data Def. Day</td>
                                <td id="dd_day"><?php echo $dataDefDay; ?></td>
                            </tr>
                            <tr>
                                <td>Data Def. Bal.</td>
                                <td id="dd_bal"><?php echo $dataDefBalance; ?> </td>
                            </tr>
                            <tr>
                                <td>Data Def. Fixes</td>
                                <td id="dd_fix"><?php echo $dataDefFixes; ?></td>
                            </tr>
                            <tr>
                                <td>Data Def. Rep.</td>
                                <td id="dd_rep"><?php echo $dataDefReputation; ?></td>
                            </tr>
                            <tr>
                                <td>Data Def. Space</td>
                                <td id="hs_dataDefTotalSpace"></td>
                            </tr>
                            <tr>
                                <td>Data Def. Hosting</td>
                                <td id="hs_dataDefTotalHosting"></td>
                            </tr>
                        </table>
                        <div class="hide">
                            <p id="dd_ss1_init"><?php echo $dd_ss1; ?></p>
                            <p id="dd_hs1_init"><?php echo $dd_hs1; ?></p>
                            <p id="dd_ss2_init"><?php echo $dd_ss2; ?></p>
                            <p id="dd_hs2_init"><?php echo $dd_hs2; ?></p>
                            <p id="dd_ss3_init"><?php echo $dd_ss3; ?></p>
                            <p id="dd_hs3_init"><?php echo $dd_hs3; ?></p>
                            <p id="dd_ss4_init"><?php echo $dd_ss4; ?></p>
                            <p id="dd_hs4_init"><?php echo $dd_hs4; ?></p>
                        </div>
    
                    </div>
                </div>
                <div class="hp_bottom_middle">
                    <div class="hp_gameBTNs">
                        <button class="trivia_home_button hp_btn" onclick="playTrivia()"></button>
                        <button class="keyHunters_home_button hp_btn" onclick="playkeyHunters()"></button>
                        <button class="phishingFrenzy_home_button hp_btn" onclick="playPhishingFrenzy()"></button>
                        <button class="dataDefenders_home_button hp_btn" onclick="playDataDefenders()"></button>
                    </div>
                </div>
                <div class="hp_bottom_right">
                    <div class="hp_bottom_right_container">
                        <div class="feature">
                            <h4 class="hp_h4Header">
                                <i class="fa fa-lock"></i> Secure</h4>
                            <p class="hp_info">Our website is completely secure and safe to use. You can play our games with
                                peace of mind, knowing
                                that your personal information is protected.</p>
                        </div>
                        <div class="feature">
                            <h4 class="hp_h4Header">
                                <i class="fa fa-gamepad"></i> Fun
                            </h4>
                            <p class="hp_info">Our games are designed to be fun and engaging. We have a wide variety of games to
                                choose from, so you're sure to find something you enjoy.</p>
                        </div>
                        <div class="feature">
                            <h4 class="hp_h4Header">
                                <i class="fa fa-dollar"></i> Free
                            </h4>
                            <p class="hp_info">All of our games are completely free to play. You don't need to spend any money
                                to have fun on our website.</p>
                        </div>
                    </div>
                </div>
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
                <button id="trivia_Back_btn1" class="trivia_Back_btn btn" onclick="trivia_resetGame()">Back</button>
            </div>
        </div>

        <div id="trivia_triv" class="trivia_triv hide">
            <div id="trivia_score" class="trivia_score hide">
                <div class="triv_inGame_Home_div">
                    <button id="triv_inGame_Home" class="triv_inGame_Home"><i class="fa fa-home" aria-hidden="true"></i></button>
                </div>
                <div id="trivia_score_rank">
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
                    <hr class="triv_bigBlack">

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
                    <span id="trivia_displayRealRank" class="trivia_displayRealRank hide">
                        <span>Current Trivia Rank: </span><span id="triv_RR"><?php echo $triviaRank; ?></span>
                    </span>
                    <button id="trivia_start_btn" class="trivia_start_btn btn">Start</button>
                    <span id="trivia_Back_btn2"><button class="trivia_Back_btn btn" onclick="trivia_resetGame()">Back</button></span>
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
            <p id="kh_msg"><img src="img/icons/khlogo.png" alt="Key Hunter Logo" width="500" height="100"></p><br>
            <button id="kh_easy_btn" class="kh_easy_btn">
                <div class="khDifSelectTestStyling">
                    Easy
                    <div class="khbar"></div>
                    
                </div>
            </button>
            <button id="kh_medium_btn" class="kh_medium_btn btn">
                <div class="khDifSelectTestStyling">
                    Medium
                    <div class="khbar"></div>
                </div>
            </button>
            <button id="kh_hard_btn" class="kh_hard_btn btn">
                <div class="khDifSelectTestStyling">
                    Hard
                    <div class="khbar"></div>
                </div>
            </button>
            <br>
            <button id="kh_home_btn" class="kh_home_btn btn">&#8962;<br></button>
            <br>
            <p class=kh_titleBlue>Current High Score:</p>
            <p id="kh_inGameHighscoreDisplay" class=kh_titleBlue><?php echo $keyHunterHighScore; ?></p>
        </div>
        <div id="kh_inGame" class="kh_inGame hide">

            <div class="kh_left">
                <div id="kh_question_container" class="kh_question_container">
                    <div id="kh_cipher_container" class="kh_cipher_container">
                        <p id="kh_btnVal">--</p>
                        <hr>
                        <div id="kh_question"></div>
                        <hr>
                    </div>

                    <div id = "kh_information_container" class = "kh_information_container">
                        <div id = "numberOfGuesses">-- </div>
                        <div id ="kh_timer">--</div>
                        <div id ="kh_score_keeper">--</div>
                        <div id ="kh_ciphers_completed">--</div>
                    </div>
                </div>

                <div id="kh_panel_container" class="kh_panel_container">
                    <div id="kh_dict_panel" class="kh_panel">
                        <h1>Dictionary</h1>
                    </div>
                    <div id="kh_msg_panel" class="kh_panel">
                        <h1 text-align="center">Messages</h1>
                    </div>

                    <div id="kh_note_panel" class="kh_note_panel">
                        <div id="kh_note_header" class="kh_note_header">
                        <h1>Notebook</h1>
                        </div>
                        <div class="kh_note_content">
                        <textarea class="kh_note_textarea" id="kh_note_textarea"></textarea>
                        </div>
                    </div>

                    <div id="kh_help_panel" class="kh_panel">
                        <img src="img/icons/khlogo.png" alt="Key Hunter Logo" width="300" height="60"><br>
                        Key Hunters is game all about ciphers! For each session you will given a random assortment of ciphers. 
                        3 for Easy, 3 for Medium, and 6 for hard. Each time these ciphers will be randomly generated, and you
                        must decipher the code to find the answer. 
                    </div>
                </div>
            </div>
            
                
            <div class="kh_table_container">
                <table id="kh_table" class="kh_table">
                </table>
            </div>

            <div id="kh_tabs_container" class="kh_tabs_container">
                <button id="kh_dict_button" class="kh_tab_button">
                    <img id="kh_button_icon" class="kh_button_icon" src="img/icons/dict.png">
                </button>
                <button id="kh_msg_button" class="kh_tab_button">
                    <img id="kh_button_icon" class="kh_button_icon" src="img/icons/msg.png">
                </button>
                <button id="kh_note_button" class="kh_tab_button">
                    <img id="kh_button_icon" class="kh_button_icon" src="img/icons/note.png">
                </button>
                <button id="kh_help_button" class="kh_tab_button">
                    <img id="kh_button_icon" class="kh_button_icon" src="img/icons/help.png">
                </button>
                <button id="kh_home_button" class="kh_tab_button_home" onclick="kh_inGameHome()">
                    <i class="fa fa-home" aria-hidden="true"></i>
                </button>
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
                    <div><span id="pf_topHomeText" class="pf_topHomeText hide">Home:</span> <button id="pf_topHome" class="pf_topHome hide"><i class="fa fa-home" aria-hidden="true"></i></button>
                        &emsp;Lives:</div>
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
                                adjust your DiFfIcUlTy settings:</p>
                            <button id="pf_easy"
                                class="pf_easy">http://www.easy.com/rll/DyzZxHtqLqI6BBjRp2syzNpl9HP/kc7XRxgz8Sx</button>
                            <button id="pf_medium"
                                class="pf_medium">http://www.medium.com/aHKV4rag4CHcmyShUmO4r7uiZ1RRKu530pGKtO</button>
                            <button id="pf_hard"
                                class="pf_hard">http://www.hard.com/rll/ssfflf3F36jxTkZNribqX97X8r33pcRxM2S/1gv</button>
                            <hr class="pf_smallBlackHr">
                            <button id="pf_home"
                                class="pf_home">http://www.home.com/VzcTOj4ZCsX80q5uMv_4jaNLgwNer8Y1MS7SR5za1X</button><br>
                            <p class="pf_highscoreDisplay">Your CuRreNT HigHSCorE iS: <br><span id="pf_hsInTab"></span></p>
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
                    </div>
                    <div class="pf_scrollDesign"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="datadefenders" class="datadefenders hide">
        <div id="ddOpenScreen" class="ddOpenScreen">
            <div class="ddhome">
                <div class="ddHomeTables">
                    <table class="ddScoresDisplay">
                        <tr>
                            <th>Welcome: </th>
                            <th id="ddUsername"></th>
                        </tr>
                        <tr>
                            <td>Money:</td>
                            <td>$<span id="ddMoney"></span></td>
                        </tr>
                        <tr>
                            <td>Daily Pay:</td>
                            <td>$<span id="ddDailyPayEstimate">0</span></td>
                        </tr>
                        <tr>
                            <td>Fixes: </td>
                            <td id="ddSaves"></td>
                        </tr>
                        <tr>
                            <td>Reputation: </td>
                            <td id="ddRep">100</td>
                        </tr>
                    </table>
                    <table class="ddServerTableDisplay">
                        <tr>
                            <th>Server ID: </th>
                            <th>Space</th>
                            <th>Hosting</th>
                        </tr>
                        <tr>
                            <td>Server 1: </td>
                            <td id="ddServ1Space">2</td>
                            <td id="ddServ1Host">2</td>
                        </tr>
                        <tr>
                            <td>Server 2: </td>
                            <td id="ddServ2Space">1</td>
                            <td id="ddServ2Host">1</td>
                        </tr>
                        <tr>
                            <td>Server 3: </td>
                            <td id="ddServ3Space">1</td>
                            <td id="ddServ3Host">1</td>
                        </tr>
                        <tr>
                            <td>Server 4: </td>
                            <td id="ddServ4Space">3</td>
                            <td id="ddServ4Host">3</td>
                        </tr>
                    </table>
                    <button id="ddstartNewDayButton" class="ddstartNewDayButton" onclick="ddStartNewDay()">&#9658;Start New
                        Day&#9658;</button>
                </div>
                <div id="ddShop" class="ddShop hide">
                    <div id="ddShopContainer" class="ddShopContainer">
                        <br>
                        <div id="ddShopBorder" class="ddShopBorder">
                            <h1 class="ddMiddleHeader" style="font-weight: bolder;">Store</h1>
                            <h2 class="ddMiddleHeader">Upgrade Servers to Add More Space which <br>will Allow you to Host
                                More Websites?</h2>
                            <table class="ddShopTable">
                                <thead>
                                    <tr>
                                        <th>Server ID</th>
                                        <th>Price</th>
                                        <th>Purchase</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Server 1</td>
                                        <td class="ddServUpgradeCost"><span id="ddUpgradeServ1$">$</span><span
                                                id="ddUpgradeServ1"></span></td>
                                        <td><button id="ddAddSpaceServ1" class="ddAddSpace"
                                                onclick="ddBuyServSpace(1)">+</button></td>
                                    </tr>
                                    <tr>
                                        <td>Server 2</td>
                                        <td class="ddServUpgradeCost"><span id="ddUpgradeServ2$">$</span><span
                                                id="ddUpgradeServ2"></span></td>
                                        <td><button id="ddAddSpaceServ2" class="ddAddSpace"
                                                onclick="ddBuyServSpace(2)">+</button></td>
                                    </tr>
                                    <tr>
                                        <td>Server 3</td>
                                        <td class="ddServUpgradeCost"><span id="ddUpgradeServ3$">$</span><span
                                                id="ddUpgradeServ3"></span></td>
                                        <td><button id="ddAddSpaceServ3" class="ddAddSpace"
                                                onclick="ddBuyServSpace(3)">+</button></td>
                                    </tr>
                                    <tr>
                                        <td>Server 4</td>
                                        <td class="ddServUpgradeCost"><span id="ddUpgradeServ4$">$</span><span
                                                id="ddUpgradeServ4"></span></td>
                                        <td><button id="ddAddSpaceServ4" class="ddAddSpace"
                                                onclick="ddBuyServSpace(4)">+</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="ddtaskbar" class="ddtaskbar">
            <div class="ddLeftTaskBar">
                <div class="ddWIcons">
                    <div id="ddSunny" class="ddSunny hide"><i class="ddSun fa fa-sun-o" aria-hidden="true"></i></div>
                    <div id="ddCloudy" class="ddCloudy hide"><i class="ddCloud fa fa-cloud" aria-hidden="true"></i>
                    </div>
                    <div id="ddRainy" class="ddRainy hide"><i class="ddRain fa fa-tint" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="ddtempAndDesc">
                    <div class="ddTempurature"><span id="ddTemp"></span><span>&#176;F</span></div>
                    <div id="ddWeatherDesc" class="ddWeatherDesc"></div>
                </div>
            </div>
            <div class="ddMiddleTaskBar">
                <button id="ddHome" class="ddTaskBtn ddTaskBtnHome" onclick="ddHomePress()"><i class="fa fa-home" aria-hidden="true"></i></button>
                <button id="ddOpenWeb" class="ddTaskBtn" onclick="ddOpenTab('ddwebsitesList')">Websites</button>
                <button id="ddOpenServer" class="ddTaskBtn" onclick="ddOpenTab('ddServerRoom')">Servers</button>
                <button id="ddOpenReport" class="ddTaskBtn ddTaskBtnReport" onclick="ddOpenTab('ddreport')">Report</button>
                <button id="ddOpenCams" class="ddTaskBtn" onclick="ddOpenTab('ddcams')">Sec. Cams</button>
                <button id="ddOpenMsg" class="ddTaskBtn" onclick="ddOpenTab('ddMsg')">Messages<span id="ddExclamation"
                        class="ddExclamation hide">!</span></button>
                <button id="ddFastFwd" class="ddTaskBtn" onclick="fastForward()"><i id="ddFastFowardBtn"
                        class="fa fa-fast-forward" aria-hidden="true"></i></button>
            </div>
            <div class="ddRightTaskBar">
                <i class="taskdetail fa fa-chevron-up" aria-hidden="true"></i>
                <i class="taskdetail fa fa-wifi"></i>
                <i class="taskdetail fa fa-volume-up" aria-hidden="true"></i>
                <i class="taskdetail fa fa-battery-three-quarters" aria-hidden="true"></i>
                <div class="ddDateAndTimeTask">
                    <div class="ddTime"><span id="ddhour">9</span>:<span id="ddminute">00</span> <span
                            id="ddDayHalf">AM</span></div>
                    <div class="ddDate">Day <span id="ddDayCount">001</span></div>
                </div>
                <i class="fa fa-bell-o" aria-hidden="true"></i>
            </div>
        </div>
        <div id="ddwebsitesList" class="ddwebsitesList hide">
            <table id="ddWebsitesTable" class="ddWebsitesTable">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Website Name</th>
                        <th>Domain Name</th>
                        <th>Directory Path</th>
                        <th>IP Address</th>
                        <th>Server Software</th>
                        <th>Server ID</th>
                        <th>Files</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div id="ddWebFiles" class="ddWebFiles hide">
                <div class="ddWebFileExit"><button class="ddwebTableBack" onclick="ddBackToWebTable()">X</button></div>
                <div id="ddWebFilesList" class="ddWebFilesList">
                    <p><span>&#x1F4C1;</span><span id="ddWebFileName1">index</span><span>.html</span></p>
                    <p><span>&#x1F4C1;</span><span id="ddWebFileName2">index</span><span>.css</span></p>
                    <p><span>&#x1F4C1;</span><span id="ddWebFileName3">index</span><span>.js</span></p>
                    <p><span>&#x1F4C1;</span><span id="ddWebFileName4">index</span><span>.sql</span></p>
                    <p><span>&#x1F4C1;</span><span id="ddWebFileName5">index</span><span>.php</span></p>
                </div>
            </div>
        </div>
        <div id="ddServerRoom" class="ddServerRoom hide">
            <div class="serverContent">
                <div id="server1" class="server" onclick="ddOpenLogs(1)">
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
                        <p>Connection: <span id="connectionHP1"></span></p>
                        <p>Download Speed: <span id="downloadSpeedHP1"></span></p>
                        <p>Upload Speed: <span id="uploadSpeedHP1"></span></p>
                    </div>
                </div>
                <div id="server2" class="server" onclick="ddOpenLogs(2)">
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
                        <p>Connection: <span id="connectionHP2"></span></p>
                        <p>Download Speed: <span id="downloadSpeedHP2"></span></p>
                        <p>Upload Speed: <span id="uploadSpeedHP2"></span></p>
                    </div>
                </div>
                <div id="server3" class="server" onclick="ddOpenLogs(3)">
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
                        <p>Connection: <span id="connectionHP3"></span></p>
                        <p>Download Speed: <span id="downloadSpeedHP3"></span></p>
                        <p>Upload Speed: <span id="uploadSpeedHP3"></span></p>
                    </div>
                </div>
                <div id="server4" class="server" onclick="ddOpenLogs(4)">
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
                        <p>Connection: <span id="connectionHP4"></span></p>
                        <p>Download Speed: <span id="downloadSpeedHP4"></span></p>
                        <p>Upload Speed: <span id="uploadSpeedHP4"></span></p>
                    </div>
                </div>
            </div>
        </div>
        <div id="ddServerLogs" class="ddServerLogs hide">
            <div class="ddLogHead">
                <h1 class="ddServerLogHeader">Server Log <span id="ddservid">1</span></h1>
            </div>
            <div id="ddlogTableContainer" class="ddlogTableContainer">
    
            </div>
            <div class="ddBottomLogContainer">
                <div class="ddlogStatsContainer">
                    <div id="logStatus" class="logStatus">
                        <p>Connection: <span id="logConnection"></span></p>
                        <p>Download Speed: <span id="logDownloadSpeed"></span></p>
                        <p>Upload Speed: <span id="logUploadSpeed"></span></p>
                        <p>Connections Made: <span id="logConnectionsMade">0</span></p>
                        <button id="ddLogBackBtn" class="ddLogBackBtn" onclick="ddlogBack()">Back</button>
                    </div>
                </div>
                <div class="ddLogGraphContainer">
                    <div class="ddGraphWhole">
                        <div class="ddTopGraph">Performance</div>
                        <div class="ddGraphMiddle">
                            <div class="ddLeftGraph">
                                <div class="percentElement">100%-</div>
                                <div class="percentElement">90%-</div>
                                <div class="percentElement">80%-</div>
                                <div class="percentElement">70%-</div>
                                <div class="percentElement">60%-</div>
                                <div class="percentElement">50%-</div>
                                <div class="percentElement">40%-</div>
                                <div class="percentElement">30%-</div>
                                <div class="percentElement">20%-</div>
                                <div class="percentElement">10%-</div>
                                <div class="percentElement">0%-</div>
                            </div>
                            <canvas id="ddGraphCanvas" class="ddGraphCanvas"></canvas>
                        </div>
                        <div class="ddBtmGraph">
                            <div class="ddBtmGraphInterval">
                                <div class="ddtimeElement">|</div>
                                <div class="ddtimeElement">|</div>
                                <div class="ddtimeElement">|</div>
                                <div class="ddtimeElement">|</div>
                                <div class="ddtimeElement">|</div>
                                <div class="ddtimeElement">|</div>
                                <div class="ddtimeElement">|</div>
                                <div class="ddtimeElement">|</div>
                                <div class="ddtimeElement">|</div>
                                <div class="ddtimeElement">|</div>
                            </div>
                            <p class="ddtimeLabel">Seconds</p>
                        </div>
                    </div>
                </div>
                <!-- NEW -->
                <div id = "ddAlertMessage" class = "ddAlertMessage hide">
                    <div class = "ddAlertBox">
                        <h1>ALERT</h1>
                        <p>SUSPICIOUS DATABASE ACTIVITY HAS BEEN DETECTED ON THIS SERVER</p>
                        <p>INVESTIGATION REQUIRED</p>
                        <p>UNUSUAL SYSTEM CALL:</p>
                        <P id = "unusualCall"></P>
                    </div>
                </div>
            </div>
        </div>
        <div id="ddcams" class="ddcams hide">
            <div id="ddCamScreenWhole" class="ddCamScreenWhole">
                <div id="screen1" class="screen1 ddIndivScreen">
                    <div class="ddIndivScreenTop">
                        <div class="flash"></div>
                        <div id="ddInsider1" class="ddInsider hide" onclick="ddToggleNametag()"></div>
                        <div id="ddUSB1" class="ddUSB hide" onclick="ddUSBPickUp(1)"></div>
                    </div>
                    <div class="ddIndivScreenBottom">Server 1</div>
                </div>
                <div id="screen2" class="ddIndivScreen">
                    <div class="ddIndivScreenTop">
                        <div class="flash"></div>
                        <div id="ddInsider2" class="ddInsider hide" onclick="ddToggleNametag()"></div>
                        <div id="ddUSB2" class="ddUSB hide" onclick="ddUSBPickUp(2)"></div>
                    </div>
                    <div class="ddIndivScreenBottom">Server 2</div>
                </div>
                <div id="screen3" class="ddIndivScreen">
                    <div class="ddIndivScreenTop">
                        <div class="flash"></div>
                        <div id="ddInsider3" class="ddInsider hide" onclick="ddToggleNametag()"></div>
                        <div id="ddUSB3" class="ddUSB hide" onclick="ddUSBPickUp(3)"></div>
                    </div>
                    <div class="ddIndivScreenBottom">Server 3</div>
                </div>
                <div id="screen4" class="ddIndivScreen">
                    <div class="ddIndivScreenTop">
                        <div class="flash"></div>
                        <div id="ddInsider4" class="ddInsider hide" onclick="ddToggleNametag()"></div>
                        <div id="ddUSB4" class="ddUSB hide" onclick="ddUSBPickUp(4)"></div>
                    </div>
                    <div class="ddIndivScreenBottom">Server 4</div>
                </div>
            </div>
            <div id="ddNametag" class="ddNametag hide" onclick="ddToggleNametag()">
                <h1 class="ddNametagGreeting"> Hello My Name is:</h1>
                <div id="ddNametagName" class="ddNametagName"></div>
                <div class="ddLowerNameTag">
                    <div class="ddRoleBox">
                        <div class="ddRoleTagText">Role: </div>
                        <div id="ddRoleTypeText" class="ddRoleTypeText"></div>
                    </div>
                    <div class="ddAccessLvlBox">
                        <div class="ddAccessTagText">Access Level: </div>
                        <div id="ddAccessTypeText" class="ddAccessTypeText"></div>
                    </div>
                </div>
            </div>
        </div>
        <div id="ddreport" class="ddreport hide">
            <div id="ddReportType" class="ddReportType">
                <!-- ------------------------------------ -->
                <div class="ddReportTypesContainer">
                    <h1 class="ddreportBtnHeader">Report Forms:</h1>
                    <hr>
                    <button class="ddGetReportForm" onclick="createDoSForm()">
                        <div class="ddReportFormText"><mark class="ddMarkWhite">DoS Attack</mark></div>
                    </button>
                    <button class="ddGetReportForm" onclick="createMalwareForm()">
                        <div class="ddReportFormText"><mark class="ddMarkWhite">Malware Attack</mark></div>
                    </button>
                    <button class="ddGetReportForm" onclick="createInsiderForm()">
                        <div class="ddReportFormText"><mark class="ddMarkWhite">Insider Intruder</mark></div>
                    </button>
                    <button class="ddGetReportForm" onclick="createDNSForm()">
                        <div class="ddReportFormText"><mark class="ddMarkWhite">DNS Spoof</mark></div>
                    </button>
                    <button class="ddGetReportForm" onclick="createSQLInjectionForm()">
                        <div class="ddReportFormText"><mark class="ddMarkWhite">SQL Injection</mark></div>
                    </button>
                    <button class="ddGetReportForm" onclick="initCreateUSBDropForm()">
                        <div class="ddReportFormText"><mark class="ddMarkWhite">USB Drop</mark></div>
                    </button>
                </div>
            </div>
            <div id="ddReportFormContainer" class="ddReportFormContainer hide"></div>
            <button id="ddDeleteReportForm" class="ddDeleteReportForm hide" onclick="removeReportForm()">X</button>
        </div>
        <div id="ddMsg" class="ddMsg hide">
            <div class="ddSenderBox">
                <h2 class="ddmessageTitle">Messages</h2>
                <div class="ddSenderContainer">
                    <!-- Sender Information will be added dynamically through JavaScript -->
                </div>
            </div>
            <div class="ddMessageContainer">
                <div class="ddMessageBox">
                    <div class="ddMessage hide">
                        <!-- Messages will be added dynamically through JavaScript -->
                    </div>
                </div>
            </div>
        </div>
        <!-- New content: Booklet button-->
        <div class="ddInfoBookButtonContainer">
            <button class="ddInfoButton ddTab" onclick="displayInfoBooklet()">&#x1f4d6;</button>
            <button class="ddNotesButton ddTab" onclick="displayddNotes()">&#x1f4dd;</button>
        </div>
        <div id="ddNotes" class="ddNotes hide">
            <button class="ddNotesButtonClose" onclick="displayddNotes()">X</button>
            <div id="HeaderddNotes" class="ddDraggable ddNoteHeader">
                <h1>Notebook</h1>
            </div>
            <div class="ddNotes__content">
                <textarea class="ddNotes__textarea" onmousedown="startDrag()" onmouseup="startDrag()" onfocus="startDrag()"
                    onblur="stopDrag()"></textarea>
            </div>
        </div>
    
        <!-- New Content: Booklet-->
        <div id="ddInfoBook" class="ddDraggable ddInfoBook hide">
            <div id="HeaderddInfoBook" class="ddDraggable bookHeader">
                <h1>Help Book</h1>
                <button class="ddInfoButtonClose" onclick="displayInfoBooklet()">Close</button>
            </div>
            <div class="bookContent">
                <div id="C1" class="C1">
                    <h1>Denial of Service (DoS)</h1>
                    <p>
                        DoS attacks are a type of attack where an attacker
                        floods a system or network with traffic or requests, making it unavailable to users.
                    </p>
                    <h1>Warning Signs of a DoS Attack: </h1>
                    <ol>
                        <li>Slow or unresponsive system: A DoS attack may cause a system or network to slow down or become
                            unresponsive, making it difficult or impossible for users to access it. </li>
                        <li>Unusually high traffic: A DoS attack may generate a large amount of traffic or requests, which
                            can overwhelm a system or network. </li>
                        <li>Unusual network activity: A DoS attack may generate unusual network activity, such as a sudden
                            increase in network traffic or a large number of requests from a single IP address. </li>
                        <li>Error messages: A DoS attack may cause error messages to appear on a website or in an
                            application, indicating that the system is experiencing problems. </li>
                        <li>Inability to access services: A DoS attack may prevent users from accessing certain services or
                            resources, such as websites or email. </li>
                    </ol>
                </div>
    
                <div id="C2" class="C2 hide">
                    <h1>Malware</h1>
                    <p>
                        Malware attacks are a type of attack where an attacker tries to gain unauthorized access to a system
                        or data by introducing malicious software on the target system.
                    </p>
                    <h1>Warning Signs of a Malware Attack: </h1>
                    <ol>
                        <li>Slow computer performance: If a computer or system suddenly becomes slow or unresponsive, it
                            could be a sign of a malware attack. Malware can consume a lot of system resources, making the
                            system slow or even crash. </li>
                        <li>Pop-up windows: If a user starts seeing an unusual amount of pop-up windows or ads, it could be
                            a sign of a malware attack. Malware can cause pop-up windows to appear, even when the user is
                            not browsing the web. </li>
                        <li>Changes to browser settings: If there are changes to the browser settings, such as a new
                            homepage or search engine, without the user's knowledge, it could be a sign of a malware attack.
                            Malware can change browser settings to redirect users to malicious websites. </li>
                        <li>Unfamiliar programs or toolbars: If there are unfamiliar programs or toolbars installed on a
                            system, it could be a sign of a malware attack. Malware can install additional software on the
                            target system without the user's knowledge. </li>
                        <li>Encrypted files: If files on a system suddenly become encrypted or inaccessible, it could be a
                            sign of a ransomware attack. Ransomware encrypts files and demands payment in exchange for the
                            decryption key. </li>
                    </ol>
                </div>
    
                <div id="C3" class="C3 hide">
                    <h1>Insider Intrusion</h1>
                    <p>
                        Insider attacks are a type of cyber-attack where an authorized person with access to sensitive
                        information or
                        systems misuses them for personal gain, espionage, or other malicious purposes.
                    </p>
                    <h1>Warning Signs of Insider Intrusion: </h1>
                    <ol>
                        <li>Suspicious behavior: An insider may exhibit suspicious behavior, such as avoiding security
                            measures, acting aggressively or defensively, or exhibiting changes in behavior or work
                            patterns. This behavior may be observed by coworkers or supervisors. </li>
                        <li>Unauthorized access or use of systems: An insider may access or use systems or data that they
                            are not authorized to access or use. This may include accessing sensitive information or systems
                            outside of their normal job duties or accessing data after their employment has ended. </li>
                        <li>Unusual network activity: An insider may engage in unusual network activity, such as downloading
                            large amounts of data or accessing systems outside of normal business hours. This activity may
                            be detected through network monitoring or system logs. </li>
                        <li>Changes to access privileges: An insider may attempt to change access privileges or create new
                            user accounts to gain access to sensitive information or systems. This may be done to maintain
                            access after their employment has ended or to cover their tracks. </li>
                        <li>Financial irregularities: An insider may engage in financial irregularities, such as stealing or
                            misusing company funds. This may be detected through financial audits or accounting records.
                        </li>
                    </ol>
                </div>
    
                <div id="C4" class="C4 hide">
                    <h1>DNS Spoofing</h1>
                    <p>
                        DNS spoofing attacks are a type of cyber-attack where attackers modify DNS records to redirect users
                        to malicious websites or servers.
                    </p>
                    <h1>Warning Signs of DNS spoofing: </h1>
                    <ol>
                        <li>Unexpected website redirects: If a user is redirected to a website that is unexpected or
                            unfamiliar, this may be a sign of a DNS spoofing attack. Attackers may have modified the DNS
                            record for the website to redirect users to a malicious website. </li>
                        <li>Certificate errors: If a user receives a certificate error when attempting to access a website,
                            this may be a sign of a DNS spoofing attack. Attackers may have redirected the user to a website
                            with an invalid or fake certificate. </li>
                        <li>Suspicious website behavior: If a website behaves suspiciously, such as asking for personal
                            information or downloading unexpected files, this may be a sign of a DNS spoofing attack.
                            Attackers may have redirected the user to a malicious website designed to steal sensitive
                            information. </li>
                        <li>Inconsistent IP addresses: If there are inconsistencies in the IP address for a website, this
                            may be a sign of a DNS spoofing attack. Attackers may have modified the DNS record for the
                            website to redirect users to a malicious server with a different IP address. </li>
                        <li>Slow or unresponsive websites: If a website is slow or unresponsive, this may be a sign of a DNS
                            spoofing attack. Attackers may have redirected the user to a server that is overloaded or under
                            attack.
                        </li>
                    </ol>
                </div>
    
                <div id="C5" class="C5 hide">
                    <h1>SQL Injection</h1>
                    <p>
                        SQL injection attacks are a type of web-based attack that involves exploiting 
                        vulnerabilities in a web application's SQL database.
                    <h1>Warning Signs of a SQL Injection Attack: </h1>
                    <ol>
                        <li>Unexpected results: An SQL injection attack may cause a web application to return unexpected 
                            results or display unexpected content, such as sensitive information or error messages.  </li>
                        <li>Changes in website behavior: An SQL injection attack may cause a website to behave differently than expected, 
                            such as redirecting a user to a different page or displaying unexpected content.  </li>
                        <li>Suspicious database activity: An SQL injection attack may generate unusual database activity, 
                            such as querying databases that should not be accessible to the attacker or inserting new records into a database.  </li>
                        <li>Unusual or unexpected inputs: An SQL injection attack may inject unexpected inputs into 
                            a web application, such as SQL commands or other malicious code. </li>
                        <li>Changes in database schema: An SQL injection attack may modify the structure of a 
                            database, such as creating new tables or modifying existing ones.  </li>
                    </ol>
                </div>
    
                <div id="C6" class="C6 hide">
                    <h1>USB Drop Attacks</h1>
                    <p>
                        USB drop attacks are a type of cyber-attack where attackers leave infected USB drives in public 
                        areas to entice people to plug them into their computers or other devices.
                    </p>
                    <h1>Warning Signs of a USB Drop Attack: </h1>
                    <ol>
                        <li>Suspicious USB drives: If a user finds a USB drive in a public area, such as a parking lot or 
                            public restroom, they should be cautious. A USB drive that appears to be new or has no labeling 
                            or branding may be a sign of a USB drop attack. </li>
                        <li>Unsolicited emails: Attackers may send unsolicited emails containing links to download files 
                            that appear to be important or interesting. If a user receives an email from an unknown sender 
                            or with a suspicious subject line, they should avoid clicking on any links or downloading any files. </li>
                        <li>Unusual computer behavior: If a user notices unusual behavior on their computer after plugging in 
                            a USB drive, such as files being deleted or the computer slowing down, this may be a sign of a USB 
                            drop attack. The user should immediately disconnect the USB drive and report the incident to 
                            their IT security team. </li>
                        <li>Unauthorized file transfers: If a user notices that files have been transferred from their computer 
                            without their knowledge or consent, this may be a sign of a USB drop attack. The user should immediately 
                            disconnect the USB drive and report the incident to their IT security team.  </li>
                        <li>Anti-virus alerts: Anti-virus software may detect and alert users to the presence of malware on a USB 
                            drive. If a user receives an alert from their anti-virus software after plugging in a USB drive, they 
                            should immediately disconnect the drive and report the incident to their IT security team.  </li>
                    </ol>
                </div>
    
            </div>
            <div class="bookFooter">
                <button class="backPage" onclick="turnPageDown()">Back</button>
                <button class="nextPage" onclick="turnPageUp()">Next</button>
            </div>
        </div>
    </div>

</body>
</html>