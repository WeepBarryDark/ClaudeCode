<template>
  <!-- Live Chat Widget -->
  <div class="fixed bottom-4 right-4 z-50">
    <!-- Chat Button -->
    <button v-if="!isOpen" 
            @click="toggleChat"
            class="bg-green-600 text-white p-4 rounded-full shadow-lg hover:bg-green-700 transition-colors">
      <ChatBubbleLeftIcon class="h-6 w-6" />
    </button>

    <!-- Chat Window -->
    <div v-else class="bg-white rounded-lg shadow-xl w-80 h-96 flex flex-col">
      <!-- Header -->
      <div class="bg-green-600 text-white p-4 rounded-t-lg flex items-center justify-between">
        <div class="flex items-center space-x-2">
          <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
            <UserIcon class="h-5 w-5" />
          </div>
          <div>
            <h3 class="font-semibold">Live Support</h3>
            <p class="text-xs text-green-100">We're here to help!</p>
          </div>
        </div>
        <button @click="toggleChat" class="text-green-100 hover:text-white">
          <XMarkIcon class="h-5 w-5" />
        </button>
      </div>

      <!-- Messages -->
      <div ref="messagesContainer" class="flex-1 p-4 overflow-y-auto space-y-3">
        <div v-if="messages.length === 0" class="text-center text-gray-500 text-sm">
          <p>Hi! How can we help you today?</p>
        </div>
        
        <div v-for="message in messages" :key="message.id" 
             :class="[
               'flex',
               message.sender_type === 'customer' ? 'justify-end' : 'justify-start'
             ]">
          <div :class="[
                 'max-w-xs px-3 py-2 rounded-lg text-sm',
                 message.sender_type === 'customer' 
                   ? 'bg-green-600 text-white' 
                   : 'bg-gray-100 text-gray-900'
               ]">
            <p>{{ message.message }}</p>
            <p class="text-xs opacity-75 mt-1">
              {{ formatTime(message.created_at) }}
            </p>
          </div>
        </div>
        
        <div v-if="isTyping" class="flex justify-start">
          <div class="bg-gray-100 px-3 py-2 rounded-lg">
            <div class="flex space-x-1">
              <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
              <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
              <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Input Form -->
      <form @submit.prevent="sendMessage" class="p-4 border-t">
        <div class="flex space-x-2">
          <input v-model="newMessage" 
                 type="text" 
                 placeholder="Type your message..."
                 class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent"
                 :disabled="isSending" />
          <button type="submit" 
                  :disabled="!newMessage.trim() || isSending"
                  class="bg-green-600 text-white p-2 rounded-lg hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
            <PaperAirplaneIcon class="h-5 w-5" />
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, nextTick, onMounted, onUnmounted } from 'vue'
import { 
  ChatBubbleLeftIcon, 
  XMarkIcon, 
  UserIcon, 
  PaperAirplaneIcon 
} from '@heroicons/vue/24/outline'

interface ChatMessage {
  id: string
  session_id: string
  sender_type: 'customer' | 'agent'
  sender_name: string
  message: string
  created_at: string
}

const isOpen = ref(false)
const messages = ref<ChatMessage[]>([])
const newMessage = ref('')
const isSending = ref(false)
const isTyping = ref(false)
const messagesContainer = ref<HTMLElement>()
const sessionId = ref('')

onMounted(() => {
  // Generate or retrieve session ID
  sessionId.value = localStorage.getItem('chat_session_id') || generateSessionId()
  localStorage.setItem('chat_session_id', sessionId.value)
  
  // Load chat history if needed
  loadChatHistory()
})

const toggleChat = () => {
  isOpen.value = !isOpen.value
  if (isOpen.value) {
    nextTick(() => {
      scrollToBottom()
    })
  }
}

const sendMessage = async () => {
  if (!newMessage.value.trim() || isSending.value) return

  const messageText = newMessage.value.trim()
  newMessage.value = ''
  isSending.value = true

  // Add message to local state immediately
  const userMessage: ChatMessage = {
    id: Date.now().toString(),
    session_id: sessionId.value,
    sender_type: 'customer',
    sender_name: 'You',
    message: messageText,
    created_at: new Date().toISOString()
  }

  messages.value.push(userMessage)
  scrollToBottom()

  try {
    // Here you would send the message to your backend
    // For now, simulate a response
    simulateAgentResponse(messageText)
  } catch (error) {
    console.error('Failed to send message:', error)
  } finally {
    isSending.value = false
  }
}

const simulateAgentResponse = (userMessage: string) => {
  isTyping.value = true
  
  setTimeout(() => {
    isTyping.value = false
    
    let response = "Thank you for your message! Our team will get back to you shortly."
    
    // Simple keyword-based responses
    const lowerMessage = userMessage.toLowerCase()
    if (lowerMessage.includes('price') || lowerMessage.includes('cost')) {
      response = "For pricing information, please check our products page or contact our sales team at (555) 123-4567."
    } else if (lowerMessage.includes('sample')) {
      response = "You can order free samples from our samples page. We'll send up to 8 samples at no charge!"
    } else if (lowerMessage.includes('installation')) {
      response = "We offer professional installation services. Would you like me to connect you with our installation team?"
    } else if (lowerMessage.includes('warranty')) {
      response = "All our products come with comprehensive warranties. The specific warranty depends on the product type and brand."
    }

    const agentMessage: ChatMessage = {
      id: (Date.now() + 1).toString(),
      session_id: sessionId.value,
      sender_type: 'agent',
      sender_name: 'Support Agent',
      message: response,
      created_at: new Date().toISOString()
    }

    messages.value.push(agentMessage)
    scrollToBottom()
  }, 1000 + Math.random() * 2000) // Random delay between 1-3 seconds
}

const loadChatHistory = () => {
  // Here you would load chat history from your backend
  // For now, we'll just show a welcome message if it's a new session
  if (messages.value.length === 0) {
    const welcomeMessage: ChatMessage = {
      id: 'welcome',
      session_id: sessionId.value,
      sender_type: 'agent',
      sender_name: 'Support Agent',
      message: 'Hello! Welcome to Ecos Flooring. How can I help you today?',
      created_at: new Date().toISOString()
    }
    messages.value.push(welcomeMessage)
  }
}

const scrollToBottom = () => {
  nextTick(() => {
    if (messagesContainer.value) {
      messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight
    }
  })
}

const formatTime = (timestamp: string) => {
  return new Date(timestamp).toLocaleTimeString([], { 
    hour: '2-digit', 
    minute: '2-digit' 
  })
}

const generateSessionId = () => {
  return 'chat_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9)
}
</script>