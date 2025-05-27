<?php
session_start();
?>

<link rel="stylesheet" href="css/chatbot.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="chat-toggle" id="chatToggle">
    <i class="fas fa-comments"></i>
</div>

<div class="chat-container hidden" id="chatContainer">
    <div class="chat-header">
        <span>Smart Chef Assistant</span>
        <i class="fas fa-times" id="closeChat" style="cursor: pointer;"></i>
    </div>
    <div class="chat-messages" id="chatMessages">
        <div class="message bot-message">
            Bonjour ! Je suis votre assistant culinaire. Comment puis-je vous aider aujourd'hui ?
        </div>
    </div>
    <div class="chat-input">
        <input type="text" id="userInput" placeholder="Posez votre question ici...">
        <button id="sendMessage">
            <i class="fas fa-paper-plane"></i>
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatToggle = document.getElementById('chatToggle');
    const chatContainer = document.getElementById('chatContainer');
    const closeChat = document.getElementById('closeChat');
    const userInput = document.getElementById('userInput');
    const sendMessage = document.getElementById('sendMessage');
    const chatMessages = document.getElementById('chatMessages');

    chatToggle.addEventListener('click', () => {
        chatContainer.classList.remove('hidden');
        chatToggle.classList.add('hidden');
    });

    closeChat.addEventListener('click', () => {
        chatContainer.classList.add('hidden');
        chatToggle.classList.remove('hidden');
    });

    function addMessage(message, isUser = false) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${isUser ? 'user-message' : 'bot-message'}`;
        messageDiv.textContent = message;
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    async function sendToBot(message) {
        try {
            const response = await fetch('chatbot_api.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ message: message })
            });
            
            const data = await response.json();
            return data.response;
        } catch (error) {
            console.error('Error:', error);
            return "Désolé, une erreur s'est produite. Veuillez réessayer.";
        }
    }

    async function handleUserMessage() {
        const message = userInput.value.trim();
        if (message) {
            addMessage(message, true);
            userInput.value = '';
            userInput.disabled = true;
            sendMessage.disabled = true;

            const botResponse = await sendToBot(message);
            addMessage(botResponse);

            userInput.disabled = false;
            sendMessage.disabled = false;
            userInput.focus();
        }
    }

    sendMessage.addEventListener('click', handleUserMessage);
    userInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            handleUserMessage();
        }
    });
});
</script> 