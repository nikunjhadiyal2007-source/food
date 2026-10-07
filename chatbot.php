<?php
if (session_status() == PHP_SESSION_NONE) session_start();
include(__DIR__ . "/config/db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Help Assistant</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/chatbot.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Chat Widget Styles */
.chat-widget {
    position: fixed;
    bottom: 100px;
    right: 20px;
    z-index: 9999;
    font-family: 'Arial', sans-serif;
}

.chat-toggle {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 20px rgba(231, 76, 60, 0.4);
    transition: all 0.3s ease;
    border: none;
    color: white;
    font-size: 1.8rem;
}

.chat-toggle:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 25px rgba(231, 76, 60, 0.5);
}

.chat-toggle.active {
    background: linear-gradient(135deg, #95a5a6, #7f8c8d);
}

.notification-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #f39c12;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    font-size: 0.7rem;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: bounce 2s infinite;
}

@keyframes bounce {

    0%,
    20%,
    50%,
    80%,
    100% {
        transform: translateY(0);
    }

    40% {
        transform: translateY(-5px);
    }

    60% {
        transform: translateY(-3px);
    }
}

.chat-container {
    position: absolute;
    bottom: 100px !important;
    right: 0;
    width: 350px;
    height: 500px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    display: none;
    flex-direction: column;
    overflow: hidden;
    border: 1px solid #e0e0e0;
    animation: slideUp 0.3s ease-out;
}

.chat-container.active {
    display: flex;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px) scale(0.95);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.chat-header {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
    padding: 15px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.chat-header-info h3 {
    font-size: 1.1rem;
    margin-bottom: 2px;
}

.chat-header-info p {
    font-size: 0.8rem;
    opacity: 0.9;
}

.chat-close {
    background: none;
    border: none;
    color: white;
    font-size: 1.2rem;
    cursor: pointer;
    padding: 5px;
    border-radius: 3px;
    transition: background 0.2s ease;
}

.chat-close:hover {
    background: rgba(255, 255, 255, 0.1);
}

.chat-messages {
    flex: 1;
    padding: 15px;
    overflow-y: auto;
    background: #f8f9fa;
}

.chat-messages::-webkit-scrollbar {
    width: 4px;
}

.chat-messages::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.chat-messages::-webkit-scrollbar-thumb {
    background: #c0c0c0;
    border-radius: 2px;
}

.message {
    margin-bottom: 15px;
    animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.message.bot {
    display: flex;
    align-items: flex-start;
}

.message.user {
    display: flex;
    align-items: flex-start;
    justify-content: flex-end;
}

.message-content {
    max-width: 80%;
    padding: 10px 14px;
    border-radius: 15px;
    font-size: 0.9rem;
    line-height: 1.4;
}

.message.bot .message-content {
    background: white;
    color: #333;
    border: 1px solid #e0e0e0;
    margin-left: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.message.user .message-content {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    margin-right: 8px;
}

.bot-avatar,
.user-avatar {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}

.bot-avatar {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
}

.user-avatar {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
}

.quick-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-top: 8px;
}

.quick-action {
    background: rgba(52, 152, 219, 0.1);
    color: #2980b9;
    border: 1px solid #3498db;
    border-radius: 12px;
    padding: 4px 10px;
    font-size: 0.75rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.quick-action:hover {
    background: #3498db;
    color: white;
    transform: translateY(-1px);
}

.chat-input {
    padding: 15px;
    background: white;
    border-top: 1px solid #e0e0e0;
}

.input-container {
    display: flex;
    gap: 8px;
    align-items: center;
}

.message-input {
    flex: 1;
    padding: 10px 12px;
    border: 1px solid #ddd;
    border-radius: 20px;
    font-size: 0.9rem;
    outline: none;
    transition: border-color 0.2s ease;
}

.message-input:focus {
    border-color: #3498db;
}

.send-button {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    border: none;
    border-radius: 50%;
    width: 35px;
    height: 35px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    transition: all 0.2s ease;
}

.send-button:hover {
    transform: scale(1.05);
}

.typing-indicator {
    display: none;
    align-items: center;
    margin-bottom: 10px;
}

.typing-dots {
    display: flex;
    gap: 3px;
    margin-left: 38px;
}

.typing-dot {
    width: 6px;
    height: 6px;
    background: #e74c3c;
    border-radius: 50%;
    animation: typingDots 1.4s infinite;
}

.typing-dot:nth-child(2) {
    animation-delay: 0.2s;
}

.typing-dot:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes typingDots {

    0%,
    60%,
    100% {
        opacity: 0.3;
    }

    30% {
        opacity: 1;
    }
}

.help-link {
    color: #3498db;
    text-decoration: underline;
    cursor: pointer;
    font-weight: 500;
}

.help-link:hover {
    color: #2980b9;
}

/* Mobile responsiveness */
@media (max-width: 480px) {
    .chat-container {
        width: calc(100vw - 40px);
        height: 450px;
        bottom: 90px;
        right: 20px;
        left: 20px;
    }

    .chat-widget {
        right: 20px;
    }
}
    </style>
</head>
<body>
    <!-- Chat Widget -->
    <div class="chat-widget">
        <div class="chat-container" id="chatContainer">
            <div class="chat-header">
                <div class="chat-header-info">
                    <h3>🍽️ Help Assistant</h3>
                    <p>How can I help you today?</p>
                </div>
                <button class="chat-close" onclick="toggleChat()">×</button>
            </div>

            <div class="chat-messages" id="chatMessages">
                <div class="message bot">
                    <div class="bot-avatar">🍽️</div>
                    <div class="message-content">
                        Hi! I'm here to help you navigate our website and answer questions about our restaurant. What would you like to know?
                        <div class="quick-actions">
                            <div class="quick-action" onclick="sendQuickReply('How to book a table?')">📅 How to book</div>
                            <div class="quick-action" onclick="sendQuickReply('Where is the menu?')">🍽️ Find menu</div>
                            <div class="quick-action" onclick="sendQuickReply('Restaurant hours?')">🕐 Hours</div>
                            <div class="quick-action" onclick="sendQuickReply('Contact info?')">📞 Contact</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="typing-indicator" id="typingIndicator">
                <div class="typing-dots">
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                </div>
            </div>

            <div class="chat-input">
                <div class="input-container">
                    <input type="text" id="messageInput" class="message-input" placeholder="Ask me anything..." autocomplete="off">
                    <button class="send-button" onclick="sendMessage()">➤</button>
                </div>
            </div>
        </div>

        <button class="chat-toggle" id="chatToggle" onclick="toggleChat()">
            💬
            <div class="notification-badge" id="notificationBadge" style="display: none;">1</div>
        </button>
    </div>

    <script>
        const chatContainer = document.getElementById('chatContainer');
        const chatToggle = document.getElementById('chatToggle');
        const chatMessages = document.getElementById('chatMessages');
        const messageInput = document.getElementById('messageInput');
        const typingIndicator = document.getElementById('typingIndicator');
        const notificationBadge = document.getElementById('notificationBadge');

        let isOpen = false;
        let hasNewMessage = false;

        // Help responses - guides users to website features
        const helpResponses = {
            'book': [
                "To book a table, look for the <span class='help-link'>'Reservations'</span> or <span class='help-link'>'Book Now'</span> button on our homepage. You can also find it in the main navigation menu. Would you like me to guide you to any specific section?",
                "You can make reservations through our booking system! Check the top of the page for the <span class='help-link'>'Reserve Table'</span> button, or look for the booking form on our homepage."
            ],
            'menu': [
                "Our full menu is available under the <span class='help-link'>'Menu'</span> section in the main navigation. You'll find all our appetizers, main courses, desserts, and drink options there. Looking for something specific?",
                "The menu is located in the navigation bar at the top of the page. Click on <span class='help-link'>'Menu'</span> to see all our delicious offerings!"
            ],
            'hours': [
                "Our restaurant hours are typically displayed in the footer of the website or in the <span class='help-link'>'Contact'</span> section. You can also find them on our <span class='help-link'>'About Us'</span> page.",
                "Check the bottom of any page for our operating hours, or visit our <span class='help-link'>'Contact'</span> page for detailed information about when we're open!"
            ],
            'contact': [
                "You can find our contact information in the <span class='help-link'>'Contact Us'</span> section, usually in the main menu or footer. This includes our phone number, address, and email.",
                "Look for the <span class='help-link'>'Contact'</span> link in the navigation menu for our phone number, address, and directions to our restaurant!"
            ],
            'location': [
                "Our restaurant location and directions are available in the <span class='help-link'>'Contact'</span> or <span class='help-link'>'Location'</span> section. You might also find a map there!",
                "Check the <span class='help-link'>'Contact Us'</span> page for our full address and directions. There's usually a map to help you find us easily!"
            ],
            'order': [
                "For online ordering, look for <span class='help-link'>'Order Online'</span> or <span class='help-link'>'Delivery'</span> buttons on the homepage. Some restaurants also have takeout options listed in the menu section.",
                "Online ordering is usually available through a dedicated <span class='help-link'>'Order Now'</span> button. Check the top of the homepage or main navigation!"
            ],
            'special': [
                "Daily specials and promotions are often featured on the homepage or in a <span class='help-link'>'Specials'</span> section. Some restaurants also list them in the menu area.",
                "Look for <span class='help-link'>'Today's Specials'</span> on the homepage, or check our social media links for the latest offers and promotions!"
            ],
            'dietary': [
                "Dietary information is usually found in the menu section. Look for symbols or a separate <span class='help-link'>'Dietary Options'</span> section. You can also check our <span class='help-link'>'About'</span> page for allergen information.",
                "Most menus have dietary indicators (vegetarian, gluten-free, etc.). If you need specific allergen information, check the menu section or contact us directly!"
            ]
        };

        function toggleChat() {
            isOpen = !isOpen;
            
            if (isOpen) {
                chatContainer.classList.add('active');
                chatToggle.classList.add('active');
                chatToggle.innerHTML = '×';
                messageInput.focus();
                notificationBadge.style.display = 'none';
                hasNewMessage = false;
            } else {
                chatContainer.classList.remove('active');
                chatToggle.classList.remove('active');
                chatToggle.innerHTML = '💬';
            }
        }

        function addMessage(content, isUser = false) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${isUser ? 'user' : 'bot'}`;
            
            const avatar = document.createElement('div');
            avatar.className = `${isUser ? 'user' : 'bot'}-avatar`;
            avatar.textContent = isUser ? '👤' : '🍽️';
            
            const messageContent = document.createElement('div');
            messageContent.className = 'message-content';
            messageContent.innerHTML = content;
            
            if (isUser) {
                messageDiv.appendChild(messageContent);
                messageDiv.appendChild(avatar);
            } else {
                messageDiv.appendChild(avatar);
                messageDiv.appendChild(messageContent);
                
                // Show notification if chat is closed
                if (!isOpen) {
                    notificationBadge.style.display = 'flex';
                    hasNewMessage = true;
                }
            }
            
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function showTypingIndicator() {
            typingIndicator.style.display = 'flex';
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function hideTypingIndicator() {
            typingIndicator.style.display = 'none';
        }

        function getBotResponse(userMessage) {
            const message = userMessage.toLowerCase();
            
            // Navigation help
            if (message.includes('book') || message.includes('reservation') || message.includes('table')) {
                return helpResponses.book[Math.floor(Math.random() * helpResponses.book.length)];
            }
            
            if (message.includes('menu') || message.includes('food') || message.includes('dish')) {
                return helpResponses.menu[Math.floor(Math.random() * helpResponses.menu.length)];
            }
            
            if (message.includes('hours') || message.includes('open') || message.includes('time')) {
                return helpResponses.hours[Math.floor(Math.random() * helpResponses.hours.length)];
            }
            
            if (message.includes('contact') || message.includes('phone') || message.includes('call')) {
                return helpResponses.contact[Math.floor(Math.random() * helpResponses.contact.length)];
            }
            
            if (message.includes('location') || message.includes('address') || message.includes('where')) {
                return helpResponses.location[Math.floor(Math.random() * helpResponses.location.length)];
            }
            
            if (message.includes('order') || message.includes('delivery') || message.includes('takeout')) {
                return helpResponses.order[Math.floor(Math.random() * helpResponses.order.length)];
            }
            
            if (message.includes('special') || message.includes('offer') || message.includes('deal')) {
                return helpResponses.special[Math.floor(Math.random() * helpResponses.special.length)];
            }
            
            if (message.includes('vegetarian') || message.includes('vegan') || message.includes('allergy') || message.includes('dietary')) {
                return helpResponses.dietary[Math.floor(Math.random() * helpResponses.dietary.length)];
            }
            
            // Website navigation help
            if (message.includes('find') || message.includes('where') || message.includes('locate')) {
                return "I can help you find what you're looking for! Most information is organized in our main navigation menu at the top of the page. What specifically are you trying to find?<div class='quick-actions'><div class='quick-action' onclick='sendQuickReply(\"Where is the menu?\")'>Menu</div><div class='quick-action' onclick='sendQuickReply(\"How to book a table?\")'>Booking</div><div class='quick-action' onclick='sendQuickReply(\"Contact info?\")'>Contact</div></div>";
            }
            
            if (message.includes('help') || message.includes('assist') || message.includes('guide')) {
                return "I'm here to help you navigate our website! I can guide you to:<br>📅 Table reservations<br>🍽️ Menu sections<br>📞 Contact information<br>🕐 Restaurant hours<br>📍 Location details<br><br>What would you like to find?";
            }
            
            // Greeting responses
            const greetings = ['hello', 'hi', 'hey', 'good morning', 'good evening'];
            if (greetings.some(greeting => message.includes(greeting))) {
                return "Hello! Welcome to our restaurant website! 👋 I'm here to help you find what you need. Are you looking to make a reservation, check our menu, or get restaurant information?";
            }
            
            // Default helpful responses
            const fallbacks = [
                "I'd be happy to help you navigate our website! Are you looking for our menu, reservation system, contact info, or something else?",
                "Let me help you find what you need! Try using the main navigation menu at the top of the page, or tell me what you're looking for specifically.",
                "I can guide you to the right section of our website! What information are you trying to find?",
                "Great question! Most of our key information is in the main menu at the top of the page. What specific details can I help you locate?"
            ];
            
            return fallbacks[Math.floor(Math.random() * fallbacks.length)];
        }

        function sendMessage() {
            const message = messageInput.value.trim();
            if (!message) return;
            
            addMessage(message, true);
            messageInput.value = '';
            
            showTypingIndicator();
            
            setTimeout(() => {
                hideTypingIndicator();
                const response = getBotResponse(message);
                addMessage(response);
            }, 800 + Math.random() * 600);
        }

        function sendQuickReply(message) {
            addMessage(message, true);
            
            showTypingIndicator();
            setTimeout(() => {
                hideTypingIndicator();
                const response = getBotResponse(message);
                addMessage(response);
            }, 600);
        }

        // Event listeners
        messageInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        // Show notification after page load
        setTimeout(() => {
            if (!isOpen) {
                notificationBadge.style.display = 'flex';
            }
        }, 3000);
    </script>
</body>
</html>