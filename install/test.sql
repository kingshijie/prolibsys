-- phpMyAdmin SQL Dump
-- version 3.3.7deb2build0.10.10.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2011 年 01 月 05 日 15:11
-- 服务器版本: 5.1.49
-- PHP 版本: 5.3.3-1ubuntu9.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `prolib`
--

-- --------------------------------------------------------

--
-- 表的结构 `plib_group`
--

CREATE TABLE IF NOT EXISTS `plib_group` (
  `groupid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `groupname` varchar(20) NOT NULL,
  PRIMARY KEY (`groupid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户组' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `plib_group`
--

INSERT INTO `plib_group` (`groupid`, `groupname`) VALUES
(1, '超级管理员'),
(2, '普通管理员'),
(3, '普通考生');

-- --------------------------------------------------------

--
-- 表的结构 `plib_group_permission`
--

CREATE TABLE IF NOT EXISTS `plib_group_permission` (
  `groupid` smallint(6) unsigned NOT NULL,
  `perid` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`groupid`,`perid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户组-权限 对照表';

--
-- 转存表中的数据 `plib_group_permission`
--


-- --------------------------------------------------------

--
-- 表的结构 `plib_knowledge`
--

CREATE TABLE IF NOT EXISTS `plib_knowledge` (
  `kid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `kname` varchar(20) NOT NULL,
  `mid` smallint(6) unsigned NOT NULL,
  PRIMARY KEY (`kid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='知识点' AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `plib_knowledge`
--

INSERT INTO `plib_knowledge` (`kid`, `kname`, `mid`) VALUES
(4, '语法', 4),
(5, '快速阅读', 4),
(6, '语法', 5),
(7, '逻辑', 5),
(8, '写作', 4),
(9, '听力', 4);

-- --------------------------------------------------------

--
-- 表的结构 `plib_major`
--

CREATE TABLE IF NOT EXISTS `plib_major` (
  `mid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `mname` varchar(20) NOT NULL,
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='科目' AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `plib_major`
--

INSERT INTO `plib_major` (`mid`, `mname`) VALUES
(4, '英语四级'),
(5, '英语六级');

-- --------------------------------------------------------

--
-- 表的结构 `plib_paper`
--

CREATE TABLE IF NOT EXISTS `plib_paper` (
  `paid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(40) NOT NULL,
  `construction` text NOT NULL,
  `timeNeed` tinyint(3) unsigned NOT NULL,
  `mid` smallint(6) unsigned NOT NULL,
  PRIMARY KEY (`paid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='试卷' AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `plib_paper`
--

INSERT INTO `plib_paper` (`paid`, `title`, `construction`, `timeNeed`, `mid`) VALUES
(5, '2010年6月英语四级考试', '6###Part I Writing (30 minutes)#注意：此部分试题在答题卡1上。\r\n　　Directions: For this part, you are allowed 30 minutes to write a short essay on the topic of Due Attention Should Be Given To Spelling. You should write at least 120 words following the outline given below:#49##Part II Reading Comprehension (Skimming and Scanning) (15 minutes)#Directions: In this part, you will have 15 minutes to go over the passage quickly and answer the questions on Answer Sheet 1. For questions 1-7,choose the best answer from the four choices marked A), B), C) and D). For questions 8-10, complete the sentences with the information given in the passage.#60##Part III Listening Comprehension (35 minutes)#&nbsp;#61#62#63#64#65#66#67#68#69#70#71#72#73#74#75#76#77#78#79#80#81#82#83#84#85#86##Part IV Reading Comprehension (Reading in Depth) (25 minutes)#&nbsp;#87#93#99##Part V Cloze (15 minutes)#Directions: There are 20 blanks in the following passage. For each blank there are four choices marked A), B), C) and D) on the right side of the paper. You should choose the ONE that best fits into the passage. Then mark the corresponding letter on Answer Sheet 2 with a single line through the centre.\r\n　　注意：此部分试题请在答题卡2上作答。#106##Part VI Translation (5 minutes)#Directions: Complete the sentences by translating into English the Chinese given in brackets.Please write you translation on Answer Sheet 2.\r\n　　注意：此部分试题请在答题卡2上作答，只需写出译文部分。#107#109#110#111###36###5#5#5#5#5#5#5#5#5#5#5#5#5#5#5#5#5#5#5#5#5#5#5#5#5#5#5#5#5#5#5#5#5#5#5#5', 120, 4);

-- --------------------------------------------------------

--
-- 表的结构 `plib_permission`
--

CREATE TABLE IF NOT EXISTS `plib_permission` (
  `perid` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `pername` varchar(20) NOT NULL,
  PRIMARY KEY (`perid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `plib_permission`
--


-- --------------------------------------------------------

--
-- 表的结构 `plib_prolib`
--

CREATE TABLE IF NOT EXISTS `plib_prolib` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `ans` text NOT NULL,
  `typeid` tinyint(3) unsigned NOT NULL,
  `mid` smallint(6) unsigned NOT NULL,
  `autocheck` tinyint(1) NOT NULL COMMENT '0-客观题 1-主观题',
  `isexer` tinyint(1) NOT NULL COMMENT '0-考试 1-练习',
  `parent` tinyint(1) NOT NULL COMMENT '0-普通题 1-子题',
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='题库' AUTO_INCREMENT=112 ;

--
-- 转存表中的数据 `plib_prolib`
--

INSERT INTO `plib_prolib` (`pid`, `description`, `ans`, `typeid`, `mid`, `autocheck`, `isexer`, `parent`) VALUES
(49, '1. 如今不少学生在英语学习中不重视拼写\r\n　　2. 出现这种情况的原因\r\n　　3. 为了改变这种状况，我认为…\r\n　　Due Attention Should Be Given To Spelling', '', 3, 4, 0, 0, 0),
(50, 'What eventually made Carla Toebe realize she was spending too much time on the Internet?#1#4#Her daughter''s repeated complaints.#Fatigue resulting from lack of sleep.# The poorly managed state of her house.#The high financial costs adding up.', 'A', 1, 4, 0, 0, 1),
(51, 'What does the author say about excessive Internet use?#1#4#People should be warned of its harmful consequences.#It has become virtually inevitable.#It has been somewhat exaggerated.#People haven''t yet reached agreement on its definition.', 'B', 1, 4, 0, 0, 1),
(52, 'Jonathan Bishop believes that the Internet overuse problem can be solved if people ______.#1#4#try to improve the Internet environment#become aware of its serious consequences#can realize what is important in life# can reach a consensus on its definition', 'C', 1, 4, 0, 0, 1),
(53, 'According to Professor Maressa Orzack, Internet use would be considered excessive if ______.#1#4#it seriously affected family relationships#one visited porn websites frequently#too much time was spent in chat rooms# people got involved in online gambling', 'D', 1, 4, 0, 0, 1),
(54, 'According to Orzack, people who struggle with heavy reliance on the Internet may feel ______.#1#4#discouraged#pressured#depressed#puzzled', 'A', 1, 4, 0, 0, 1),
(55, 'Why did Andre Heidrich cut back online gaming?#1#4#He had lost a lot of money.#His family had intervened.#He had offended his relatives.#His career had been ruined.', 'B', 1, 4, 0, 0, 1),
(56, 'Andrew Heidrich now visits websites that discuss online gaming addiction to ______.#1#4# improve his online gaming skills#curb his desire for online gaming#show how good he is at online gaming#exchange online gaming experience', 'B', 1, 4, 0, 0, 1),
(57, 'In one of the messages she posted on a website, Toebe admitted that she #.', '', 2, 4, 0, 0, 1),
(58, 'Excessive Internet use had rendered Toebe so poor that she couldn''t afford to seek #.', '', 2, 4, 0, 0, 1),
(59, 'Now that she''s got a boyfriend, Toebe is no longer crazy about #.', '', 2, 4, 0, 0, 1),
(60, '　　Caught in the Web\r\n　　A few months ago, it wasn''t unusual for 47-year-old Carla Toebe to spend 15 hours per day online. She''d wake up early, turn on her laptop and chat on Internet dating sites and instant-messaging programs – leaving her bed for only brief intervals. Her household bills piled up, along with the dishes and dirty laundry, but it took near-constant complaints from her four daughters before she realized she had a problem.\r\n　　"I was starting to feel like my whole world was falling apart – kind of slipping into a depression," said Carla. "I knew that if I didn''t get off the dating sites, I''d just keep going," detaching (使脱离) herself further from the outside world.\r\n　　Toebe''s conclusion: She felt like she was "addicted" to the Internet. She''s not alone.\r\n　　Concern about excessive Internet use isn''t new. As far back as 1995, articles in medical journals and the establishment of a Pennsylvania treatment center for overusers generated interest in the subject. There''s still no consensus on how much time online constitutes too much or whether addiction is possible.\r\n　　But as reliance on the Web grows, there are signs that the question is getting more serious attention: Last month, a study published in CNS Spectrums claimed to be the first large-scale look at excessive Internet use. The American Psychiatric Association may consider listing Internet addiction in the next edition of its diagnostic manual. And scores of online discussion boards have popped up on which people discuss negative experiences tied to too much time on the Web.\r\n　　"There''s no question that there''re people who''re seriously in trouble because they''re overdoing their Internet involvement," said psychiatrist (精神科医生) Ivan Goldberg. Goldberg calls the problem a disorder rather than a true addiction.\r\n　　Jonathan Bishop, a researcher in Wales specializing in online communities, is more skeptical. "The Internet is an environment," he said. "You can''t be addicted to the environment." Bishop describes the problem as simply a matter of priorities, which can be solved by encouraging people to prioritize other life goals and plans in place of time spent online.\r\n　　The new CNS Spectrums study was based on results of a nationwide telephone survey of more than 2,500 adults. Like the 2005 survey, this one was conducted by Stanford University researchers.About 6% of respondents reported that "their relationships suffered because of excessive Internet use." About 9% attempted to conceal "nonessential Internet use," and nearly 4% reported feeling "preoccupied by the Internet when offline."\r\n　　About 8% said they used the Internet as a way to escape problems, and almost 14% reported they "found it hard to stay away from the Internet for several days at a time."\r\n　　"The Internet problem is still in its infancy," said Elias Aboujaoude, a Stanford professor. No single online activity is to blame for excessive use, he said. "They''re online in chat rooms, checking e-mail, or writing blogs. [The problem is] not limited to porn (色情) or gambling" websites.\r\n　　Excessive Internet use should be defined not by the number of hours spent online but "in terms of losses," said Maressa Orzack, a Harvard University professor. "If it''s a loss [where] you''re not getting to work, and family relationships are breaking down as a result, then it''s too much."\r\n　　Since the early 1990s, several clinics have been established in the U. S. to treat heavy Internet users. They include the Center for Internet Addiction Recovery and the Center for Internet Behavior.\r\n　　The website for Orzack''s center lists the following among the psychological symptoms of computer addiction:\r\n　　● Having a sense of well-being (幸福) or excitement while at the computer.\r\n　　● Longing for more and more time at the computer.\r\n　　● Neglect of family and friends.\r\n　　● Feeling empty, depressed or irritable when not at the computer.\r\n　　● Lying to employers and family about activities.\r\n　　● Inability to stop the activity.\r\n　　● Problems with school or job.\r\n　　Physical symptoms listed include dry eyes, backaches, skipping meals, poor personal hygiene (卫生) and sleep disturbances.\r\n　　People who struggle with excessive Internet use maybe depressed or have other mood disorders, Orzack said. When she discusses Internet habits with her patients, they often report that being online offers a "sense of belonging, and escape, excitement [and] fun," she said. "Some people say relief…because they find themselves so relaxed."\r\n　　Some parts of the Internet seem to draw people in more than others. Internet gamers spend countless hours competing in games against people from all over the world. One such game, called World of Warcraft, is cited on many sites by posters complaining of a "gaming addiction."\r\n　　Andrew Heidrich, an education network administrator from Sacramento, plays World of Warcraft for about two to four hours every other night, but that''s nothing compared with the 40 to 60 hours a week he spent playing online games when he was in college. He cut back only after a full-scale family intervention (干预), in which relatives told him he''d gained weight.\r\n　　"There''s this whole culture of competition that sucks people in" with online gaming, said Heidrich, now a father of two. "People do it at the expense of everything that was a constant in their lives." Heidrich now visits websites that discuss gaming addiction regularly "to remind myself to keep my love for online games in check."\r\n　　Toebe also regularly visits a site where posters discuss Internet overuse. In August, when she first realized she had a problem, she posted a message on a Yahoo Internet addiction group with the subject line: "I have an Internet Addiction."\r\n　　"I''m self-employed and need the Internet for my work, but I''m failing to accomplish my work,to take care of my home, to give attention to my children," she wrote in a message sent to the group."I have no money or insurance to get professional help; I can''t even pay my mortgage (抵押贷款) and face losing everything."\r\n　　Since then, Toebe said, she has kept her promise to herself to cut back on her Internet use. "I have a boyfriend now, and I''m not interested in online dating," she said by phone last week. "It''s a lot better now."\r\n　　注意：此部分试题请在答题卡1上作答。#50#51#52#53#54#55#56#57#58#59', '', 4, 4, 0, 0, 0),
(61, '#1#4#He has proved to be a better reader than the woman.#He has difficulty understanding the book.#He cannot get access to the assigned book.#He cannot finish his assignment before the deadline.', 'A', 1, 4, 0, 0, 0),
(62, '#1#4#She will drive the man to the supermarket.#The man should buy a car of his own.#The man needn''t go shopping every week.#She can pick the man up at the grocery store.', 'A', 1, 4, 0, 0, 0),
(63, '#1#4#Get more food and drinks.#Ask his friend to come over.#Tidy up the place.# Hold a party.', 'A', 1, 4, 0, 0, 0),
(64, '#1#4#The talks can be held any day except this Friday.#He could change his schedule to meet John Smith.# The first-round talks should start as soon as possible.#The woman should contact John Smith first.', 'B', 1, 4, 0, 0, 0),
(65, '#1#4#He understands the woman''s feelings.#He has gone through a similar experience.#The woman should have gone on the field trip.#The teacher is just following the regulations.', 'A', 1, 4, 0, 0, 0),
(66, '#1#4#She will meet the man halfway.#She will ask David to talk less.#She is sorry the man will not come.#She has to invite David to the party.', 'A', 1, 4, 0, 0, 0),
(67, '#1#4#Few students understand Prof. Johnson''s lectures.#Few students meet Prof. Jonson''s requirements.#Many students find Prof. Johnson''s lectures boring.#Many students have dropped Prof. Johnson''s class.', 'B', 1, 4, 0, 0, 0),
(68, '#1#4#Check their computer files.#Make some computations.#Study a computer program.#Assemble a computer.', '', 1, 4, 0, 0, 0),
(69, 'Questions 19 to 22 are based on the conversation you have just heard.#1#4#A) It allows him to make a lot of friends.#It requires him to work long hours.# It enables him to apply theory to practice.# It helps him understand people better.', 'A', 1, 4, 0, 0, 0),
(70, '#1#4# It is intellectually challenging.# It requires him to do washing-up all the time.#It exposes him to oily smoke all day long.#It demands physical endurance and patience.', 'A', 1, 4, 0, 0, 0),
(71, '#1#4#In a hospital.#At a coffee shop.# At a laundry.# In a hotel.', 'A', 1, 4, 0, 0, 0),
(72, '#1#4#Getting along well with colleagues.#Paying attention to every detail.#Planning everything in advance.#Knowing the needs of customers.', 'A', 1, 4, 0, 0, 0),
(73, 'Questions 23 to 25 are based on the conversation you have just heard.#1#4# The pocket money British children get.#The annual inflation rate in Britain.#The things British children spend money on.#The rising cost of raising a child in Britain.', 'A', 1, 4, 0, 0, 0),
(74, '#1#4#It enables children to live better.#It goes down during economic recession.#It often rises higher than inflation.#It has gone up 25% in the past decade.', 'A', 1, 4, 0, 0, 0),
(75, '#1#4#Save up for their future education.#Pay for small personal things.#Buy their own shoes and socks.#Make donations when necessary.', 'A', 1, 4, 0, 0, 0),
(76, 'Questions 26 to 29 are based on the conversation you have just heard.#1#4#District managers.#Regular customers.#Sales directors.# Senior clerks.', 'A', 1, 4, 0, 0, 0),
(77, '#1#4#The support provided by the regular clients.#The initiative shown by the sales representatives.#The urgency of implementing the company''s plans.#The important part played by district managers.', 'B', 1, 4, 0, 0, 0),
(78, '#1#4#Some of them were political-minded.#Fifty percent of them were female.#One third of them were senior managers.#Most of them were rather conservative.', 'B', 1, 4, 0, 0, 0),
(79, '#1#4# He used too many quotations.#He was not gender sensitive.#He did not keep to the point.#He spent too much time on details.', 'A', 1, 4, 0, 0, 0),
(80, 'Questions 30 to 32 are based on the passage you have just heard.#1#4# State your problem to the head waiter.#Demand a discount on the dishes ordered.#Ask to see the manager politely but firmly.#Ask the name of the person waiting on you.', 'A', 1, 4, 0, 0, 0),
(81, '#1#4#You problem may not be understood correctly.#You don''t know if you are complaining at the right time.#Your complaint may not reach the person in charge.#You can''t tell how the person on the line is reacting.', 'A', 1, 4, 0, 0, 0),
(82, '#1#4#Demand a prompt response.#Provide all the details.#Send it by express mail.# Stick to the point.', 'A', 1, 4, 0, 0, 0),
(83, 'Questions 33 to 35 are based on the passage you have just heard.#1#4#Fashion designer#Architect.#City planner.#Engineer.', 'A', 1, 4, 0, 0, 0),
(84, '#1#4#Do some volunteer work.#Get a well-paid part-time job.#Work flexible hours.# Go back to her previous post.', 'A', 1, 4, 0, 0, 0),
(85, '#1#4# Few baby-sitters can be considered trustworthy.# It will add to the family''s financial burden.#A baby-sitter is no replacement for a mother.#The children won''t get along with a baby-sitter.', 'A', 1, 4, 0, 0, 0),
(86, 'Almost every child, on the first day he sets foot in a school building, is smarter, more (36)______, less afraid of what he doesn''t know, better at finding and (37) ______ things out, more confident, resourceful (机敏的), persistent and (38) ______ than he will ever be again in his schooling – or, unless he is very (39) ______ and very lucky, for the rest of his life. Already, by paying close attention to and (40) ______ with the world and people around him, and without any school-type (41) ______ instruction, he has done a task far more difficult, complicated and (42)______ than anything he will be asked to do in school, or than any of his teachers has done for years. He has solved the (43) ______ of language. He has discovered it – babies don''t even know that language exists – and (44) ________________________________________________. He has done it by exploring, by experimenting, by developing his own model of the grammar of language, (45) ________________________________________________ until it does work. And while he has been doing this, he has been learning other things as well, (46) ________________________________________________, and many that are more complicated than the ones they do try to teach him.', '', 3, 4, 0, 0, 0),
(87, 'When we think of green buildings, we tend to think of new ones – the kind of high-tech, solar-paneled masterpieces that make the covers of architecture magazines. But the U.S. has more than 100 million existing homes, and it would be __47__ wasteful to tear them all down and __48__ them with greener versions. An enormous amount of energy and resources went into the construction of those houses. And it would take an average of 65 years for the __49__ carbon emissions from a new energy-efficient home to make up for the resources lost by destroying an old one. So in the broadest __50__, the greenest home is the one that has already been built. But at the same time, nearly half of U. S. carbon emissions come from heating, cooling and __51__ our homes, offices and other buildings. "You can''t deal with climate change without dealing with existing buildings," says Richard Moe, the president of the National Trust.\r\n　　With some __52__, the oldest homes tend to be the least energy-efficient. Houses built before 1939 use about 50% more energy per square foot than those built after 2000, mainly due to the tiny cracks and gaps that __53__ over time and let in more outside air.\r\n　　Fortunately, there are a __54__ number of relatively simple changes that can green older homes, from __55__ ones like Lincoln''s Cottage to your own postwar home. And efficiency upgrades (升级) can save more than just the earth; they can help __56__ property owners from rising power costs.\r\n　　注意：此部分试题请在答题卡2上作答。\r\n  A) accommodations   B) clumsy   C) doubtful    D) exceptions   E) expand          F) historic   G) incredibly    H) powering    I) protect   J) reduced   K) replace        L) sense   M) shifted    N) supplying    O) vast', 'A#B#C#D', 3, 4, 0, 0, 0),
(88, 'What does the author say about the black box?#1#4# It ensures the normal functioning of an airplane.#The idea for its design comes from a comic book.# Its ability to ward off disasters is incredible.#It is an indispensable device on an airplane.', 'A', 1, 4, 0, 0, 1),
(89, 'What information could be found from the black box on the Yemeni airliner?#1#4#Data for analyzing the cause of the crash.#The total number of passengers on board.# The scene of the crash and extent of the damage.#Homing signals sent by the pilot before the crash.', 'A', 1, 4, 0, 0, 1),
(90, 'Why was the black box redesigned in 1965?#1#4#New materials became available by that time.#Too much space was needed for its installation.#The early models often got damaged in the crash.#The early models didn''t provide the needed data.', 'A', 1, 4, 0, 0, 1),
(91, 'Why did the Federal Aviation Authority require the black boxes be painted orange or yellow?#1#4#To distinguish them from the colour of the plane.#To caution people to handle them with care.# To make them easily identifiable.#To conform to international standards.', 'A', 1, 4, 0, 0, 1),
(92, 'What do we know about the black boxes from Air France Flight 447?#1#4#There is still a good chance of their being recovered.#There is an urgent need for them to be reconstructed.#They have stopped sending homing signals.#They were destroyed somewhere near Brazil.', 'A', 1, 4, 0, 0, 1),
(93, 'You never see him, but they''re with you every time you fly. They record where you are going,how fast you''re traveling and whether everything on your airplane is functioning normally. Their ability to withstand almost any disaster makes them seem like something out of a comic book.They''re known as the black box.\r\n　　When planes fall from the sky, as a Yemeni airliner did on its way to Comoros Islands in the India ocean June 30, 2009, the black box is the best bet for identifying what went wrong. So when a French submarine (潜水艇) detected the device''s homing signal five days later, the discovery marked a huge step toward determining the cause of a tragedy in which 152 passengers were killed.\r\n　　In 1958, Australian scientist David Warren developed a flight-memory recorder that would track basic information like altitude and direction. That was the first mode for a black box, which became a requirement on all U.S. commercial flights by 1960. Early models often failed to withstand crashes, however, so in 1965 the device was completely redesigned and moved to the rear of the plane – the area least subject to impact – from its original position in the landing wells (起落架舱). The same year, the Federal Aviation Authority required that the boxes, which were never actually black, be painted orange or yellow to aid visibility.\r\n　　Modern airplanes have two black boxes: a voice recorder, which tracks pilots'' conversations,and a flight-data recorder, which monitors fuel levels, engine noises and other operating functions that help investigators reconstruct the aircraft''s final moments. Placed in an insulated (隔绝的) case and surrounded by a quarter-inch-thick panels of stainless steel, the boxes can withstand massive force and temperatures up to 2,000℉. When submerged, they''re also able to emit signals from depths of 20,000 ft. Experts believe the boxes from Air France Flight 447, which crashed near Brazil on June 1,2009, are in water nearly that deep, but statistics say they''re still likely to turn up. In the approximately 20 deep-sea crashes over the past 30 years, only one plane''s black boxes were never recovered.#88#89#90#91#92', '', 4, 4, 0, 0, 0),
(94, 'What do we learn from the first paragraph about the self-help industry?#1#4#It is a highly profitable industry.#It is based on the concept of positive thinking.# It was established by Norman Vincent Peale.#It has yielded positive results.', 'A', 1, 4, 0, 0, 1),
(95, 'What is the finding of the Canadian researchers?#1#4#Encouraging positive thinking many do more harm than good.#There can be no simple therapy for psychological problems.#Unhappy people cannot think positively.#The power of positive thinking is limited.', 'A', 1, 4, 0, 0, 1),
(96, 'What does the author mean by "… you''re just underlining his faults" (Line 4, Para. 3)?#1#4#You are not taking his mistakes seriously enough.#You are pointing out the errors he has committed.#You are emphasizing the fact that he is not intelligent.#You are trying to make him feel better about his faults.', 'A', 1, 4, 0, 0, 1),
(97, 'What do we learn from the experiment of Wood, Lee and Perunovic?#1#4#It is important for people to continually boost their self-esteem.#Self-affirmation can bring a positive change to one''s mood.#Forcing a person to think positive thoughts may lower their self-esteem.#People with low self-esteem seldom write down their true feelings.', 'A', 1, 4, 0, 0, 1),
(98, 'What do we learn from the last paragraph?#1#4#The effects of positive thinking vary from person to person.#Meditation may prove to be a good form of psychotherapy.#Different people tend to have different ways of thinking.#People can avoid making mistakes through meditation.', 'A', 1, 4, 0, 0, 1),
(99, 'The $11 billion self-help industry is built on the idea that you should turn negative thoughts like "I never do anything right" into positive ones like "I can succeed." But was positive thinking advocate Norman Vincent Peale right? Is there power in positive thinking?\r\n　　Researchers in Canada just published a study in the journal Psychological Science that says trying to get people to think more positively can actually have the opposite effect: it can simply highlight how unhappy they are.\r\n　　The study''s authors, Joanne Wood and John Lee of the University of Waterloo and Elaine Perunovic of the University of New Brunswick, begin by citing older research showing that when people get feedback which they believe is overly positive, they actually feel worse, not better. If you tell your dim friend that he has the potential of an Einstein, you''re just underlining his faults. In one 1990s experiment, a team including psychologist Joel Cooper of Princeton asked participants to write essays opposing funding for the disabled. When the essayists were later praised for their sympathy, they felt even worse about what they had written.\r\n　　In this experiment, Wood, Lee and Perunovic measured 68 students'' self-esteem. The participants were then asked to write down their thoughts and feelings for four minutes. Every 15 seconds, one group of students heard a bell. When it rang, they were supposed to tell themselves, "I am lovable."\r\n　　Those with low self-esteem didn''t feel better after the forced self-affirmation. In fact, their moods turned significantly darker than those of members of the control group, who weren''t urged to think positive thoughts.\r\n　　The paper provides support for newer forms of psychotherapy (心理治疗) that urge people to accept their negative thoughts and feelings rather than fight them. In the fighting, we not only often fail but can make things worse. Meditation (静思) techniques, in contrast, can teach people to put their shortcomings into a larger, more realistic perspective. Call it the power of negative thinking.#94#95#96#97#98', '', 4, 4, 0, 0, 0),
(100, '#1#4#distract#descend#differ#derive', 'A', 1, 4, 0, 0, 1),
(101, '#1#4#with#via#from#off', 'A', 1, 4, 0, 0, 1),
(102, '#1#4#appeared#used#resorted#served', 'A', 1, 4, 0, 0, 1),
(103, '#1#4#situates#lies#roots#locates', 'A', 1, 4, 0, 0, 1),
(104, '#1#4#on#of#for#to', 'A', 1, 4, 0, 0, 1),
(105, '#1#4#reflects#detects#protects#selects', 'A', 1, 4, 0, 0, 1),
(106, 'The term e-commerce refers to all commercial transactions conducted over the Internet, including transactions by consumers and business-to-business transactions. Conceptually, e-commerce does not __67__ from well-known commercial offerings such as banking by phone, "mail order" catalogs, or sending a purchase order to supplier __68__ fax.E-commerce follows the same model __69__ in other business transactions; the difference __70__ in the details.\r\n　　To a consumer, the most visible form of e-commerce consists __71__ online ordering. A customer begins with a catalog of possible items, __72__ an item, arranges a form of payment, and __73__ an order. Instead of a physical catalog, e-commerce arranges for catalogs to be __74__ on the Internet. Instead of sending an order on paper or by telephone, e-commerce arranges for orders to be sent __75__ a computer network. Finally, instead of sending a paper representation of payment such as a check, e-commerce __76__ one to send payment information electronically.\r\n　　In the decade __77__ 1993, e-commerce grew from an __78__ novelty (新奇事物) to a mainstream business influence. In 1993, few __79__ had a web page, and __80__ a handful allowed one to order products or services online. Ten years __81__, both large and small businesses had web pages, and most __82__ users with the opportunity to place an order. __83__, many banks added online access, __84__ online banking and bill paying became __85__. More importantly, the value of goods and services __86__ over the Internet grew dramatically after 1997.#100#101#102#103#104#105', '', 4, 4, 0, 0, 0),
(107, 'Because of the noise outside, Nancy had great difficulty __________________ (集中注意力在实验上).', 'in concentrating in experiment.', 3, 4, 0, 0, 0),
(108, 'The manager never laughed; neither __________________ (她也从来没有发过脾气).', 'she', 2, 4, 0, 0, 0),
(109, 'We look forward to __________________ (被邀请出席开幕式).', 'be invited', 3, 4, 0, 0, 0),
(110, ' It is suggested that the air conditioner __________________ (要安装在窗户旁).', 'to', 2, 4, 0, 0, 0),
(111, 'The 16-year-old girl decided to travel abroad on her own despite __________________ (她父母的强烈反对).', 'of her parents'' opposite', 2, 4, 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `plib_prolib_knowledge`
--

CREATE TABLE IF NOT EXISTS `plib_prolib_knowledge` (
  `pid` int(10) unsigned NOT NULL,
  `kid` smallint(6) unsigned NOT NULL,
  PRIMARY KEY (`pid`,`kid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='题-知识点 对照表';

--
-- 转存表中的数据 `plib_prolib_knowledge`
--

INSERT INTO `plib_prolib_knowledge` (`pid`, `kid`) VALUES
(49, 8),
(50, 5),
(51, 5),
(52, 5),
(53, 5),
(54, 5),
(55, 5),
(56, 5),
(57, 5),
(58, 5),
(59, 5),
(60, 5),
(61, 9),
(62, 9),
(63, 9),
(64, 9),
(65, 9),
(66, 9),
(67, 9),
(68, 9),
(69, 9),
(70, 9),
(72, 9),
(73, 9),
(74, 9),
(75, 9),
(76, 9),
(77, 9),
(78, 9),
(79, 9),
(80, 9),
(81, 9),
(82, 9),
(83, 9),
(84, 9),
(85, 9),
(86, 9),
(87, 5),
(88, 5),
(89, 5),
(90, 5),
(91, 5),
(92, 5),
(93, 5),
(95, 5),
(96, 5),
(98, 5),
(99, 5),
(100, 5);

-- --------------------------------------------------------

--
-- 表的结构 `plib_protype`
--

CREATE TABLE IF NOT EXISTS `plib_protype` (
  `typeid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tname` varchar(20) NOT NULL,
  PRIMARY KEY (`typeid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='题型' AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `plib_protype`
--

INSERT INTO `plib_protype` (`typeid`, `tname`) VALUES
(1, '选择题'),
(2, '填空题'),
(3, '简答题'),
(4, '组合题'),
(5, '名词解释');

-- --------------------------------------------------------

--
-- 表的结构 `plib_result`
--

CREATE TABLE IF NOT EXISTS `plib_result` (
  `rid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tid` mediumint(8) unsigned NOT NULL,
  `uid` mediumint(8) unsigned NOT NULL,
  `ans` text NOT NULL,
  `score` tinyint(3) unsigned NOT NULL,
  `score_detail` text NOT NULL,
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='学生做题结果' AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `plib_result`
--

INSERT INTO `plib_result` (`rid`, `tid`, `uid`, `ans`, `score`, `score_detail`) VALUES
(7, 3, 5, '10###49##213###57#####58#####59#####86#####87#####107#####109#####110#####111##', 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `plib_test`
--

CREATE TABLE IF NOT EXISTS `plib_test` (
  `tid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `paid` mediumint(8) unsigned NOT NULL,
  `mid` smallint(6) unsigned NOT NULL,
  `stime` datetime NOT NULL,
  `etime` datetime NOT NULL,
  `groupids` text NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='考试' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `plib_test`
--

INSERT INTO `plib_test` (`tid`, `paid`, `mid`, `stime`, `etime`, `groupids`) VALUES
(3, 5, 4, '2010-12-20 09:00:00', '2011-12-20 09:00:00', '3');

-- --------------------------------------------------------

--
-- 表的结构 `plib_user`
--

CREATE TABLE IF NOT EXISTS `plib_user` (
  `uid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` char(32) NOT NULL,
  `uname` varchar(18) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户' AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `plib_user`
--

INSERT INTO `plib_user` (`uid`, `username`, `password`, `uname`) VALUES
(4, 'admin', 'b605e86d02eef8bfd0646f6a704c17c9', 'Admin'),
(5, 'test1', 'b605e86d02eef8bfd0646f6a704c17c9', 'Test1'),
(6, 'test2', 'b605e86d02eef8bfd0646f6a704c17c9', 'Test2'),
(7, 'test3', 'b605e86d02eef8bfd0646f6a704c17c9', 'Test3'),
(8, 'test4', 'b605e86d02eef8bfd0646f6a704c17c9', 'Test4'),
(9, 'test5', 'b605e86d02eef8bfd0646f6a704c17c9', 'Test5'),
(10, 'test6', 'b605e86d02eef8bfd0646f6a704c17c9', 'Test6');

-- --------------------------------------------------------

--
-- 表的结构 `plib_user_group`
--

CREATE TABLE IF NOT EXISTS `plib_user_group` (
  `uid` mediumint(8) unsigned NOT NULL,
  `groupid` smallint(6) unsigned NOT NULL,
  PRIMARY KEY (`uid`,`groupid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户-用户组 对照表';

--
-- 转存表中的数据 `plib_user_group`
--

INSERT INTO `plib_user_group` (`uid`, `groupid`) VALUES
(4, 1),
(5, 3),
(6, 3),
(7, 3),
(8, 3),
(9, 3),
(10, 3);
