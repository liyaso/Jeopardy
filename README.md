# Jeopardy

Group Members: Zaim Shakeel, Liya Sojan

The game of Jeopardy will be designed as a multiplayer game that will allow players to test their trivia knowledge. At least two players will register to compete against each other on a 5 by 4 grid). Each cell will have a question that is worth 200, 400, 600, or 800 dollars. Players will take turns against each other, and whoever has the most points will win.

## Setup Instructions

1. Use a local development (XAMPP on Mac/Windows)

    - To install XAMPP, go to this website and follow the instructions: https://www.apachefriends.org/
      - Once installed start the servers
    - Clone the repository into XAMPP's htdocs folder


```
cd /Applications/XAMPP/xamppfiles/htdocs #Mac
cd C:/xampp/htdocs
git clone https://github.com/liyaso/Jeopardy.git Jeopardy
```

3. Set write permissions for users.txt
```
chmod 666 /Applications/XAMPP/xamppfiles/htdocs/Jeopardy/data/user/txt
```

4. Open the project in your browser
```
http://localhost/jeopardy/
```
5. You can start playing by registering two accounts

OR Visit this URL for a live demo: 

## How to Play
1. Register two accounts 
2. Log in as Player 1
3. You will be asked who you want to play with from the dropdown menu
   - Click on who you want to play against and hit Start Game
4. Player 1 will go first
   - Click on any question from the board
5. Answer the questions and hit Submit
6. The turns will alternate until all the questions have been answered
7. The player with the highest score will win
8. Once the game has ended, the winner will be revealed, and you will be able to play again or Log Out

## Features
- Session Management
- AI Difficulty Engine
- Turn-based PHP form question/answer system — POST/GET for each turn
- Multi-player support: 2+ registered users
- Prize/score tracking stored in $_SESSION per player
- Randomized question bank: 3 difficulty tiers, 10+ questions each
- Session leaderboard updated with scores after every completed game
- Show-specific logic: category boards (Jeopardy)
