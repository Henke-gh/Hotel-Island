# Fawkes Island

It's surrounded by water. Also a reference to someones fiery bird.

# The Featherby Hotel

A place where dreams come true. In your sleep, when you dream. They're not true the morning after.

Visit the hotel at https://henkes-portfolio.se/Featherby/

# About the project

The Hotel Island repo is an assignment in which we, students of Yrgo's 2023 web dev higher vocational training, were given
the task of building a small hotel booking website. The project reqs included handling booking information, databases and
communicating with an API in order to confirm and validate payment information.

# Instructions

This project uses an SQlite database and a couple of packages (Guzzle and phpdotenv). Information about the database
structure can be found in the tableCreates.txt and install instructions for said packages are included in the
dependencies.txt file in the repository.

# Code review

1. tableCreates.txt - you could limit the amount of letters allowed when creating tables. So that unwanted scripts would be prevented from entering your database. 

2. style.css - It could use some comments and structure. Maybe naming different sections the same as the containers of your html?

3. hotelFunctions.php, 44-77 - The functions updateExtraCost and updateRoomCost could be one single function to make the code more readable.

4. loginVerify, 17 - You are assuming that the connection to you database will work, it would be better to catch it if it loses connection. So when you get errors, you'll know right away that the connection has been lost. 

5. booking.php, 37 - You could use some htmlspecialchars to sanatize your input.

6. style.css - To make the code more readable you could get rid of the "clutter" when styling. Meaning, if there's multiple parts that have the same color, you could collect them to a single style, rather then re-writing it over and over again.

7. Not a specific file, but your class-names and function-names could use an improvement overall to decrease mix-ups and such. 

8. Regarding your actual website you could think about the responsivity. Example, the three rooms available become unreadable and shrinkes in mobile-mode.

9. hotelFunctions.php, use prepare statements to sanatize your database. You have done it on mainly all places as i can see, but missed 1 or 2.

10. Index.php, 33-58 - Instead of writing the rooms out in html, you could loop them to make up for the space.
