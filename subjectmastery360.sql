-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2024 at 07:39 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `subjectmastery360`
--

-- --------------------------------------------------------

--
-- Table structure for table `chatroom_attachment`
--

CREATE TABLE `chatroom_attachment` (
  `chatroom_attachment_id` int(11) NOT NULL,
  `chatroom_messages_id` int(11) NOT NULL,
  `chatroom_attachment_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chatroom_attachment`
--

INSERT INTO `chatroom_attachment` (`chatroom_attachment_id`, `chatroom_messages_id`, `chatroom_attachment_name`) VALUES
(4, 5, '65acfefb75291_immune-system.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `chatroom_messages`
--

CREATE TABLE `chatroom_messages` (
  `chatroom_messages_id` int(11) NOT NULL,
  `classroom_member_id` int(11) NOT NULL,
  `chatroom_title` varchar(255) NOT NULL,
  `chatroom_messages_content` text NOT NULL,
  `chatroom_messages_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chatroom_messages`
--

INSERT INTO `chatroom_messages` (`chatroom_messages_id`, `classroom_member_id`, `chatroom_title`, `chatroom_messages_content`, `chatroom_messages_timestamp`) VALUES
(5, 33, 'Human Immunity System ', 'The human immunity system is a complex network of cells, tissues, and organs that work together to defend the body against harmful invaders. It is our body’s primary defense mechanism against pathogens such as bacteria, viruses, and other foreign substances.', '2024-01-21 11:24:43'),
(6, 35, 'Quantum ', 'Please study this chapter. ', '2024-01-21 11:27:36');

-- --------------------------------------------------------

--
-- Table structure for table `classroom`
--

CREATE TABLE `classroom` (
  `classroom_id` int(11) NOT NULL,
  `classroom_name` varchar(255) NOT NULL,
  `classroom_description` text NOT NULL,
  `classroom_code` varchar(7) NOT NULL,
  `classroom_picture` varchar(255) DEFAULT 'book.jpg',
  `classroom_color` varchar(255) DEFAULT 'Gray'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classroom`
--

INSERT INTO `classroom` (`classroom_id`, `classroom_name`, `classroom_description`, `classroom_code`, `classroom_picture`, `classroom_color`) VALUES
(20, 'Biology Classroom ', 'This course provides an in-depth exploration of the fundamental concepts in biology, the study of life and living organisms. It is designed to give students a broad understanding of biological principles and processes.', '1234567', '65acfea206145.jpg', 'LightCoral'),
(21, 'Physics Classroom ', 'This course unravels the mysteries of the universe through the study of physics, the science of matter and energy. It is designed to provide students with a comprehensive understanding of the physical laws that govern our world and beyond.', '3456789', 'book.jpg', 'LightGray');

-- --------------------------------------------------------

--
-- Table structure for table `classroom_exam`
--

CREATE TABLE `classroom_exam` (
  `classroom_exam_id` int(11) NOT NULL,
  `classroom_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classroom_exam`
--

INSERT INTO `classroom_exam` (`classroom_exam_id`, `classroom_id`, `exam_id`) VALUES
(9, 20, 9);

-- --------------------------------------------------------

--
-- Table structure for table `classroom_member`
--

CREATE TABLE `classroom_member` (
  `classroom_member_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `classroom_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classroom_member`
--

INSERT INTO `classroom_member` (`classroom_member_id`, `user_id`, `classroom_id`) VALUES
(33, 38, 20),
(34, 39, 20),
(35, 38, 21);

-- --------------------------------------------------------

--
-- Table structure for table `classroom_quiz`
--

CREATE TABLE `classroom_quiz` (
  `classroom_quiz_id` int(11) NOT NULL,
  `classroom_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classroom_quiz`
--

INSERT INTO `classroom_quiz` (`classroom_quiz_id`, `classroom_id`, `quiz_id`) VALUES
(7, 20, 7);

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE `exam` (
  `exam_id` int(11) NOT NULL,
  `exam_title` varchar(255) NOT NULL,
  `exam_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam`
--

INSERT INTO `exam` (`exam_id`, `exam_title`, `exam_description`) VALUES
(9, 'Biology 101: The Journey of Life', 'This exam is designed to assess your understanding of the fundamental concepts in biology. It consists of structured questions that require detailed answers. The questions cover a wide range of topics, from cellular biology to ecology, providing a comprehensive evaluation of your knowledge and understanding of the subject matter. Please read each question carefully and provide thorough and thoughtful responses. Good luck!');

-- --------------------------------------------------------

--
-- Table structure for table `exam_attempt`
--

CREATE TABLE `exam_attempt` (
  `exam_attempt_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `exam_start_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `exam_end_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_attempt`
--

INSERT INTO `exam_attempt` (`exam_attempt_id`, `exam_id`, `user_id`, `exam_start_time`, `exam_end_time`) VALUES
(12, 9, 39, '2024-01-21 11:33:36', '2024-01-21 11:35:11');

-- --------------------------------------------------------

--
-- Table structure for table `exam_feedback`
--

CREATE TABLE `exam_feedback` (
  `exam_feedback_id` int(11) NOT NULL,
  `exam_attempt_id` int(11) NOT NULL,
  `exam_feedback_content` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_feedback`
--

INSERT INTO `exam_feedback` (`exam_feedback_id`, `exam_attempt_id`, `exam_feedback_content`) VALUES
(12, 12, 'Please do more revision on this chapter. ');

-- --------------------------------------------------------

--
-- Table structure for table `exam_question`
--

CREATE TABLE `exam_question` (
  `exam_question_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `exam_question` text NOT NULL,
  `exam_marks` int(11) NOT NULL,
  `exam_attachment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_question`
--

INSERT INTO `exam_question` (`exam_question_id`, `exam_id`, `exam_question`, `exam_marks`, `exam_attachment`) VALUES
(10, 9, 'Describe the structure and function of a eukaryotic cell. Include key organelles such as the nucleus, mitochondria, endoplasmic reticulum, Golgi apparatus, and lysosomes in your answer.', 20, NULL),
(11, 9, 'Explain the process of photosynthesis. Include the role of chlorophyll, the importance of light and water, and the production of glucose and oxygen.', 20, '65ad00de8dcea.png');

-- --------------------------------------------------------

--
-- Table structure for table `exam_user_answer`
--

CREATE TABLE `exam_user_answer` (
  `exam_user_answer_id` int(11) NOT NULL,
  `exam_attempt_id` int(11) NOT NULL,
  `exam_question_id` int(11) NOT NULL,
  `exam_user_answer` text DEFAULT NULL,
  `exam_user_marks` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_user_answer`
--

INSERT INTO `exam_user_answer` (`exam_user_answer_id`, `exam_attempt_id`, `exam_question_id`, `exam_user_answer`, `exam_user_marks`) VALUES
(20, 12, 10, 'A eukaryotic cell is a type of cell that has a nucleus and other membrane-bound organelles. Eukaryotic cells are larger and more complex than prokaryotic cells, which lack these characteristics. Key organelles in a eukaryotic cell include the nucleus, mitochondria, endoplasmic reticulum, Golgi apparatus, and lysosomes.\r\n\r\nNucleus: The nucleus is often considered the control center of the cell. It houses the cell’s DNA and directs the synthesis of proteins and ribosomes.\r\n\r\nMitochondria: Often referred to as the powerhouse of the cell, mitochondria are responsible for producing ATP, the cell’s main energy-carrying molecule, through the process of cellular respiration.\r\n\r\nEndoplasmic Reticulum (ER): The ER is involved in protein and lipid synthesis. The rough ER, studded with ribosomes, modifies proteins, while the smooth ER synthesizes lipids and detoxifies certain chemicals.\r\n\r\nGolgi Apparatus: The Golgi apparatus modifies, sorts, and packages proteins and lipids for transport to their final destinations, either inside or outside the cell.\r\n\r\nLysosomes: Lysosomes contain enzymes to digest waste materials and cellular debris. They can break down a variety of substances, from bacteria and viruses to worn-out cell components.', 20),
(21, 12, 11, 'Photosynthesis is a process used by plants, algae, and certain bacteria to convert light energy, usually from the sun, into chemical energy in the form of glucose. This process is crucial for life on Earth as it provides the oxygen that most organisms need to survive.', 10);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `feedback_content` text NOT NULL CHECK (octet_length(`feedback_content`) > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `user_id`, `feedback_content`) VALUES
(6, 38, 'I am thoroughly impressed with the quality of quizzes on this website. The questions are thought-provoking and cover a wide range of topics, making it a fantastic learning resource. The user-friendly interface and the instant feedback feature enhance the overall experience. Keep up the great work!'),
(7, 39, 'The quizzes on this website are truly top-notch. They are not only informative but also engaging, making learning a fun and enjoyable process. The website is well-organized and easy to navigate, and the variety of topics available is impressive. Keep up the excellent work!');

-- --------------------------------------------------------

--
-- Table structure for table `feedback_attachment`
--

CREATE TABLE `feedback_attachment` (
  `feedback_attachment_id` int(11) NOT NULL,
  `feedback_id` int(11) NOT NULL,
  `feedback_file_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback_attachment`
--

INSERT INTO `feedback_attachment` (`feedback_attachment_id`, `feedback_id`, `feedback_file_name`) VALUES
(2, 6, '65ad0225890c8.png');

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `quiz_id` int(11) NOT NULL,
  `quiz_title` varchar(255) NOT NULL,
  `quiz_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`quiz_id`, `quiz_title`, `quiz_description`) VALUES
(7, 'The Wonders of Life: A Biology Challenge', 'This quiz is designed to test your knowledge of the fascinating world of biology. It covers a wide range of topics, from the smallest cells to the largest ecosystems. Whether you’re a biology novice or a seasoned expert, this quiz will challenge your understanding of life and its intricate processes. So, put on your thinking cap and get ready to dive into the wonders of life! Good luck!');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_attempt`
--

CREATE TABLE `quiz_attempt` (
  `quiz_attempt_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `quiz_start_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `quiz_end_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_attempt`
--

INSERT INTO `quiz_attempt` (`quiz_attempt_id`, `user_id`, `quiz_id`, `quiz_start_time`, `quiz_end_time`) VALUES
(8, 39, 7, '2024-01-21 11:33:25', '2024-01-21 11:33:32');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_feedback`
--

CREATE TABLE `quiz_feedback` (
  `quiz_feedback_id` int(11) NOT NULL,
  `quiz_attempt_id` int(11) NOT NULL,
  `quiz_feedback_content` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_feedback`
--

INSERT INTO `quiz_feedback` (`quiz_feedback_id`, `quiz_attempt_id`, `quiz_feedback_content`) VALUES
(8, 8, 'Well Done');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_option`
--

CREATE TABLE `quiz_option` (
  `quiz_option_id` int(11) NOT NULL,
  `quiz_question_id` int(11) NOT NULL,
  `option_text` varchar(255) NOT NULL,
  `iscorrect` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_option`
--

INSERT INTO `quiz_option` (`quiz_option_id`, `quiz_question_id`, `option_text`, `iscorrect`) VALUES
(56, 14, 'Mitochondria', 1),
(57, 14, 'Nucleus', 0),
(58, 14, 'Endoplasmic Reticulum', 0),
(59, 14, 'Golgi Apparatus', 0),
(60, 15, 'Meiosis', 1),
(61, 15, 'Mitosis', 0),
(62, 15, 'Binary Fission', 0),
(63, 15, 'Budding', 0);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_question`
--

CREATE TABLE `quiz_question` (
  `quiz_question_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `quiz_question_text` text NOT NULL CHECK (octet_length(`quiz_question_text`) > 0),
  `quiz_mark` int(11) NOT NULL,
  `quiz_attachment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_question`
--

INSERT INTO `quiz_question` (`quiz_question_id`, `quiz_id`, `quiz_question_text`, `quiz_mark`, `quiz_attachment`) VALUES
(14, 7, 'What is the powerhouse of the cell?', 2, '65ad003aa6e9a.jpg'),
(15, 7, 'Which process is responsible for the genetic diversity during sexual reproduction?\r\n\r\n', 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_user_answer`
--

CREATE TABLE `quiz_user_answer` (
  `quiz_user_answer_id` int(11) NOT NULL,
  `quiz_attempt_id` int(11) NOT NULL,
  `quiz_question_id` int(11) NOT NULL,
  `answer` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_user_answer`
--

INSERT INTO `quiz_user_answer` (`quiz_user_answer_id`, `quiz_attempt_id`, `quiz_question_id`, `answer`) VALUES
(21, 8, 14, 56),
(22, 8, 15, 60);

-- --------------------------------------------------------

--
-- Table structure for table `reply`
--

CREATE TABLE `reply` (
  `reply_id` int(11) NOT NULL,
  `classroom_member_id` int(11) NOT NULL,
  `chatroom_messages_id` int(11) NOT NULL,
  `reply_text` text NOT NULL,
  `reply_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reply`
--

INSERT INTO `reply` (`reply_id`, `classroom_member_id`, `chatroom_messages_id`, `reply_text`, `reply_timestamp`) VALUES
(9, 33, 5, 'Please do your revision after you studied this chapter. Thank You. ', '2024-01-21 11:24:55'),
(10, 34, 5, 'Hi Teacher, i have completed doing revision on this chapter. ', '2024-01-21 11:26:24');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role`) VALUES
(1, 'student'),
(2, 'teacher'),
(4, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `username` varchar(15) NOT NULL,
  `user_first_name` varchar(15) NOT NULL,
  `user_last_name` varchar(15) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `password` varchar(22) NOT NULL,
  `institute_name` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT 'user.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `role_id`, `username`, `user_first_name`, `user_last_name`, `email_address`, `password`, `institute_name`, `profile_picture`) VALUES
(4, 4, 'admin', 'admin', 'admin', 'admin@gmail.com', 'admin', '', NULL),
(38, 2, 'North', 'North', 'Goh', 'North@gmail.com', 'North_123', 'Asia Pacific University', '65acfe463e049.jpg'),
(39, 1, 'DenDen', 'Den ', 'Den', 'Denden@gmail.com', 'Denden_123', '', 'user.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chatroom_attachment`
--
ALTER TABLE `chatroom_attachment`
  ADD PRIMARY KEY (`chatroom_attachment_id`),
  ADD KEY `chatroom_attachment_ibfk_1` (`chatroom_messages_id`);

--
-- Indexes for table `chatroom_messages`
--
ALTER TABLE `chatroom_messages`
  ADD PRIMARY KEY (`chatroom_messages_id`),
  ADD KEY `chatroom_messages_ibfk_1` (`classroom_member_id`);

--
-- Indexes for table `classroom`
--
ALTER TABLE `classroom`
  ADD PRIMARY KEY (`classroom_id`);

--
-- Indexes for table `classroom_exam`
--
ALTER TABLE `classroom_exam`
  ADD PRIMARY KEY (`classroom_exam_id`),
  ADD KEY `classroom_id` (`classroom_id`),
  ADD KEY `classroom_exam_ibfk_2` (`exam_id`);

--
-- Indexes for table `classroom_member`
--
ALTER TABLE `classroom_member`
  ADD PRIMARY KEY (`classroom_member_id`),
  ADD KEY `classroom_id` (`classroom_id`),
  ADD KEY `classroom_member_ibfk_1` (`user_id`);

--
-- Indexes for table `classroom_quiz`
--
ALTER TABLE `classroom_quiz`
  ADD PRIMARY KEY (`classroom_quiz_id`),
  ADD KEY `classroom_id` (`classroom_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`exam_id`);

--
-- Indexes for table `exam_attempt`
--
ALTER TABLE `exam_attempt`
  ADD PRIMARY KEY (`exam_attempt_id`),
  ADD KEY `exam_id` (`exam_id`),
  ADD KEY `exam_attempt_ibfk_2` (`user_id`);

--
-- Indexes for table `exam_feedback`
--
ALTER TABLE `exam_feedback`
  ADD PRIMARY KEY (`exam_feedback_id`),
  ADD KEY `exam_feedback_ibfk_1` (`exam_attempt_id`);

--
-- Indexes for table `exam_question`
--
ALTER TABLE `exam_question`
  ADD PRIMARY KEY (`exam_question_id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Indexes for table `exam_user_answer`
--
ALTER TABLE `exam_user_answer`
  ADD PRIMARY KEY (`exam_user_answer_id`),
  ADD KEY `exam_question_id` (`exam_question_id`),
  ADD KEY `exam_user_answer_ibfk_1` (`exam_attempt_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `feedback_ibfk_1` (`user_id`);

--
-- Indexes for table `feedback_attachment`
--
ALTER TABLE `feedback_attachment`
  ADD PRIMARY KEY (`feedback_attachment_id`),
  ADD KEY `feedback_attachment_ibfk_1` (`feedback_id`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`quiz_id`);

--
-- Indexes for table `quiz_attempt`
--
ALTER TABLE `quiz_attempt`
  ADD PRIMARY KEY (`quiz_attempt_id`),
  ADD KEY `quiz_attempt_ibfk_2` (`quiz_id`),
  ADD KEY `quiz_attempt_ibfk_1` (`user_id`);

--
-- Indexes for table `quiz_feedback`
--
ALTER TABLE `quiz_feedback`
  ADD PRIMARY KEY (`quiz_feedback_id`),
  ADD KEY `quiz_feedback_ibfk_1` (`quiz_attempt_id`);

--
-- Indexes for table `quiz_option`
--
ALTER TABLE `quiz_option`
  ADD PRIMARY KEY (`quiz_option_id`),
  ADD KEY `quiz_option_ibfk_1` (`quiz_question_id`);

--
-- Indexes for table `quiz_question`
--
ALTER TABLE `quiz_question`
  ADD PRIMARY KEY (`quiz_question_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `quiz_user_answer`
--
ALTER TABLE `quiz_user_answer`
  ADD PRIMARY KEY (`quiz_user_answer_id`),
  ADD KEY `quiz_question_id` (`quiz_question_id`),
  ADD KEY `answer` (`answer`),
  ADD KEY `quiz_user_answer_ibfk_1` (`quiz_attempt_id`);

--
-- Indexes for table `reply`
--
ALTER TABLE `reply`
  ADD PRIMARY KEY (`reply_id`),
  ADD KEY `reply_ibfk_1` (`classroom_member_id`),
  ADD KEY `reply_ibfk_2` (`chatroom_messages_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_ibfk_1` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chatroom_attachment`
--
ALTER TABLE `chatroom_attachment`
  MODIFY `chatroom_attachment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `chatroom_messages`
--
ALTER TABLE `chatroom_messages`
  MODIFY `chatroom_messages_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `classroom`
--
ALTER TABLE `classroom`
  MODIFY `classroom_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `classroom_exam`
--
ALTER TABLE `classroom_exam`
  MODIFY `classroom_exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `classroom_member`
--
ALTER TABLE `classroom_member`
  MODIFY `classroom_member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `classroom_quiz`
--
ALTER TABLE `classroom_quiz`
  MODIFY `classroom_quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `exam`
--
ALTER TABLE `exam`
  MODIFY `exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `exam_attempt`
--
ALTER TABLE `exam_attempt`
  MODIFY `exam_attempt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `exam_feedback`
--
ALTER TABLE `exam_feedback`
  MODIFY `exam_feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `exam_question`
--
ALTER TABLE `exam_question`
  MODIFY `exam_question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `exam_user_answer`
--
ALTER TABLE `exam_user_answer`
  MODIFY `exam_user_answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `feedback_attachment`
--
ALTER TABLE `feedback_attachment`
  MODIFY `feedback_attachment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `quiz_attempt`
--
ALTER TABLE `quiz_attempt`
  MODIFY `quiz_attempt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `quiz_feedback`
--
ALTER TABLE `quiz_feedback`
  MODIFY `quiz_feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `quiz_option`
--
ALTER TABLE `quiz_option`
  MODIFY `quiz_option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `quiz_question`
--
ALTER TABLE `quiz_question`
  MODIFY `quiz_question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `quiz_user_answer`
--
ALTER TABLE `quiz_user_answer`
  MODIFY `quiz_user_answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `reply`
--
ALTER TABLE `reply`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chatroom_attachment`
--
ALTER TABLE `chatroom_attachment`
  ADD CONSTRAINT `chatroom_attachment_ibfk_1` FOREIGN KEY (`chatroom_messages_id`) REFERENCES `chatroom_messages` (`chatroom_messages_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `chatroom_messages`
--
ALTER TABLE `chatroom_messages`
  ADD CONSTRAINT `chatroom_messages_ibfk_1` FOREIGN KEY (`classroom_member_id`) REFERENCES `classroom_member` (`classroom_member_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `classroom_exam`
--
ALTER TABLE `classroom_exam`
  ADD CONSTRAINT `classroom_exam_ibfk_1` FOREIGN KEY (`classroom_id`) REFERENCES `classroom` (`classroom_id`),
  ADD CONSTRAINT `classroom_exam_ibfk_2` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`exam_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `classroom_member`
--
ALTER TABLE `classroom_member`
  ADD CONSTRAINT `classroom_member_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `classroom_member_ibfk_2` FOREIGN KEY (`classroom_id`) REFERENCES `classroom` (`classroom_id`);

--
-- Constraints for table `classroom_quiz`
--
ALTER TABLE `classroom_quiz`
  ADD CONSTRAINT `classroom_quiz_ibfk_1` FOREIGN KEY (`classroom_id`) REFERENCES `classroom` (`classroom_id`),
  ADD CONSTRAINT `classroom_quiz_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`quiz_id`);

--
-- Constraints for table `exam_attempt`
--
ALTER TABLE `exam_attempt`
  ADD CONSTRAINT `exam_attempt_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`exam_id`),
  ADD CONSTRAINT `exam_attempt_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exam_feedback`
--
ALTER TABLE `exam_feedback`
  ADD CONSTRAINT `exam_feedback_ibfk_1` FOREIGN KEY (`exam_attempt_id`) REFERENCES `exam_attempt` (`exam_attempt_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exam_question`
--
ALTER TABLE `exam_question`
  ADD CONSTRAINT `exam_question_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`exam_id`);

--
-- Constraints for table `exam_user_answer`
--
ALTER TABLE `exam_user_answer`
  ADD CONSTRAINT `exam_user_answer_ibfk_1` FOREIGN KEY (`exam_attempt_id`) REFERENCES `exam_attempt` (`exam_attempt_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_user_answer_ibfk_2` FOREIGN KEY (`exam_question_id`) REFERENCES `exam_question` (`exam_question_id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `feedback_attachment`
--
ALTER TABLE `feedback_attachment`
  ADD CONSTRAINT `feedback_attachment_ibfk_1` FOREIGN KEY (`feedback_id`) REFERENCES `feedback` (`feedback_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quiz_attempt`
--
ALTER TABLE `quiz_attempt`
  ADD CONSTRAINT `quiz_attempt_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quiz_attempt_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`quiz_id`);

--
-- Constraints for table `quiz_feedback`
--
ALTER TABLE `quiz_feedback`
  ADD CONSTRAINT `quiz_feedback_ibfk_1` FOREIGN KEY (`quiz_attempt_id`) REFERENCES `quiz_attempt` (`quiz_attempt_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quiz_option`
--
ALTER TABLE `quiz_option`
  ADD CONSTRAINT `quiz_option_ibfk_1` FOREIGN KEY (`quiz_question_id`) REFERENCES `quiz_question` (`quiz_question_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quiz_question`
--
ALTER TABLE `quiz_question`
  ADD CONSTRAINT `quiz_question_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`quiz_id`);

--
-- Constraints for table `quiz_user_answer`
--
ALTER TABLE `quiz_user_answer`
  ADD CONSTRAINT `quiz_user_answer_ibfk_1` FOREIGN KEY (`quiz_attempt_id`) REFERENCES `quiz_attempt` (`quiz_attempt_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quiz_user_answer_ibfk_2` FOREIGN KEY (`quiz_question_id`) REFERENCES `quiz_question` (`quiz_question_id`),
  ADD CONSTRAINT `quiz_user_answer_ibfk_3` FOREIGN KEY (`answer`) REFERENCES `quiz_option` (`quiz_option_id`);

--
-- Constraints for table `reply`
--
ALTER TABLE `reply`
  ADD CONSTRAINT `reply_ibfk_1` FOREIGN KEY (`classroom_member_id`) REFERENCES `classroom_member` (`classroom_member_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reply_ibfk_2` FOREIGN KEY (`chatroom_messages_id`) REFERENCES `chatroom_messages` (`chatroom_messages_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
