-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2024 at 06:46 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `serverside`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `content` mediumtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `content`, `date`) VALUES
(8, 'Where is the message?', 'here!', '2024-01-27 07:00:59'),
(30, 'INTERVIEW &ndash; Tim Richter ', 'CEO &amp; President of the Canadian Alliance to End Homelessness, Tim Richter, spoke earlier this week with Bryn Griffiths host of 630 CHED Afternoons on homelessness, tent fires and the current rise in housing insecurity in Edmonton and across Canada. \r\n\r\nOn the wave of homelessness currently rising across the country, Tim Richter said: \r\n\r\nWe&rsquo;re seeing a wave of new homelessness across the country. It really began during the pandemic and it has surged since then. We probably have between 260,000 to 300,000 Canadians experiencing homelessness over the course of a year and that&rsquo;s a good 30% higher than what it has been.\r\nOn the surprising demographics of the people who are experiencing homelessness now: \r\n\r\nYou see the demographic of homelessness shifting as people are really being pushed out the bottom end of the rental housing market. It&rsquo;s everything from people turning up at the Pearson airport in Toronto seeking asylum from somewhere else in the world to seniors being forced out of their homes to young people to Indigenous people.\r\nOn how Edmonton lost the progress it had made reducing homelessness: \r\n\r\nEdmonton had the largest reduction of homelessness of any major Canadian city, nearly 43% between 2009 and 2019. It was a stunning achievement. But that was largely erased since 2019 and the cost of living crisis.\r\nListen to the full audio for more revelations on what has led to the rise of homelessness in Edmonton and how to counter homelessness on 630 CHED.', '2024-01-30 05:39:01'),
(31, 'National Housing', 'Ottawa, Ontario (November 21, 2023) &ndash; The authors of the National Housing Accord (NHA), the Canadian Alliance to End Homelessness, REALPAC, and the PLACE Centre at the Smart Prosperity Institute, welcome the housing measures announced today in the federal government&rsquo;s Fall Economic Statement, and look forward to further measures  to urgently to address the housing crisis facing Canadians. \r\n\r\nThe federal government&rsquo;s Fall Economic Statement includes: \r\n\r\n$15 billion of additional loans for new purpose-built rentals as part of a refreshed Apartment Construction Loan Program (formerly the Rental Housing Construction Finance Initiative); \r\n$1 billion additional direct funding to the Affordable Housing Fund (formerly the National Housing Co-Investment Fund) for more affordable homes; \r\n$300 million for Cooperative housing development; \r\nthe removal of GST for new cooperative housing; \r\nresources for municipalities and provinces to enforce short-term rental restrictions; and  \r\na new Canada Mortgage Charter to support those with increasing mortgage costs.  \r\nThis builds on the two recent announcements of the removal of GST on purpose-built rental and increased limit for Canada Mortgage Bonds to support rental housing. \r\n\r\n&ldquo;The announcement of $16 billion worth of investments in additional loans for affordable and market rentals, funding for affordable housing and reforms to get more homes built faster is welcome,&rdquo; says Tim Richter, President &amp; CEO of the Canadian Alliance to End Homelessness. &ldquo;However, with affordability worsening, homelessness surging and the dream of home ownership continuing to slip away for many, the federal government must move more aggressively to solve the housing crisis. I&rsquo;m especially concerned with the notable absence of measures to address homelessness as we start another harsh and dangerous winter.&rdquo; \r\n\r\n&ldquo;We welcome the measures announced by the federal government today and are encouraged by the positive impact it will have on the construction of new rental and affordable homes. This is a commendable first step, and we look forward to working closely with all levels of government to achieve the target of 2 million purpose-built rental and 655,000 affordable social homes by 2030, to restore housing affordability for all,&rdquo; says Michael Brooks, CEO of REALPAC. \r\n\r\n&ldquo;Canadians are increasingly concerned about the housing crisis and their own housing. A recent Abacus Data poll showed that 82% of Canadians with children think that the federal government&rsquo;s number one priority should be making housing more affordable,&rdquo; says Dr. Mike Moffatt, Founding Director, PLACE Centre at the Smart Prosperity Institute. &ldquo;Today&rsquo;s economic update is a move in the right direction, but we must continue act urgently to address the housing crisis and keep up with population growth.&rdquo; ', '2024-01-30 05:39:48'),
(32, 'Non-profit', 'a group of Canadian housing sector organizations &ndash; non-profit and for-profit housing providers, developers, and investors &ndash; came together at a Roundtable to create The National Housing Accord: A Multi-Sector Approach to Ending Canada&rsquo;s Rental Housing Crisis. ', '2024-01-30 05:40:43'),
(33, 'Remembrance Day', 'This week, we remember the sacrifices that veterans have made throughout our country&rsquo;s history. We honour those who have served in both war and in peacetime, here in Canada and abroad.', '2024-01-30 05:41:47'),
(34, '2022 National Conference', 'More than 1,600 delegates from across Canada and the world will be gathering in person in Toronto and virtually for the next three days at the National Conference on Ending Homelessness &ndash; CAEH22.\r\n\r\n&ldquo;A new wave of homelessness is hitting Canada caused by a number of overlapping crises happening right now,&rdquo; says Tim Richter, President and CEO of the Canadian Alliance to End Homelessness. &ldquo;The housing crisis, poisoned drug supply and COVID-19 had already devastated Canadians experiencing homelessness and those working in the sector. Now, the escalating cost-of-living crisis is forcing more people into homelessness across the country.&rdquo; \r\n\r\n&ldquo;Despite this, there is hope and action,&rdquo; says Don Iveson, co-chair of CAEH and former mayor of Edmonton. &ldquo;Communities across the country are having success in reducing and ending homelessness. By learning from their successes and the methods that are working &ndash; and with increased government support &ndash; we can stop this new wave of homelessness and support those already experiencing it into housing.&rdquo; \r\n\r\nAt the conference, participants will share their successes, lessons and insights from the communities and organizations working to end homelessness across Canada and abroad. It&rsquo;s set to be both a challenging and inspiring event, empowering people working to end homelessness with the skills, knowledge, and new connections they need to be successful.  \r\n\r\nParticipants include front-line workers, community leaders, researchers, advocates, government officials &ndash; and importantly, over 150 people with lived experience of homelessness will be joining the conference and will guide and inform the discussions and lessons over the course of the event. \r\n\r\nThis year&rsquo;s program features 85 sessions in 14 streams, five keynotes, delivered by more than 250 national and international experts. The program is crammed with some great innovations on everything from responding to unsheltered homelessness to transforming emergency shelters, achieving the right to housing, responding to homelessness for women, advancing Reconciliation, responding to homelessness in rural communities, integrating health care and homeless systems and much more.    \r\n\r\nTo learn more, visit https://conference.caeh.ca. ', '2024-01-30 05:42:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
