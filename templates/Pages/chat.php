<div class="w-1/2 h-screen mx-auto bg-white rounded-lg overflow-hidden shadow-lg">
    <!-- Chat Header -->
    <div class=" bg-green-700 text-white py-4 px-6 flex items-center">
        <img src="https://i.pinimg.com/originals/16/cf/43/16cf43ed08453f58b17e7c126e714a99.jpg" alt="Bot Avatar" class="h-10 w-10 rounded-full mr-3 border-2 border-white" />
        <h6 class="text-lg font-semibold text-white">Chatbot</h6>
    </div>



    <!-- Chat Messages -->
    <div class="p-4" id="chat-messages" style="height: 77%;">
      <!-- Bot Message -->
      <div class="flex mb-4">
        <div class="flex-shrink-0">
          <img src="https://i.pinimg.com/originals/16/cf/43/16cf43ed08453f58b17e7c126e714a99.jpg" alt="Bot Avatar" class="h-8 w-8 rounded-full" />
        </div>
        <div class="ml-3 bg-gray-100 py-2 px-3 rounded-md">
          <p class=" text-gray-800">Hello! How can I help you today?</p>
        </div>
      </div>

      <!-- User Message -->
      <div class="flex justify-end mb-4">
        <div class="bg-[#fb7185] py-2 px-3 rounded-md text-white">
          <p class="">I have a question about my account.</p>
        </div>
      </div>

    </div>

    <!-- Chat Input -->
    <div class="bg-gray-200 p-4 flex items-center">
      <input type="text" placeholder="Type your message..." class="flex-1 py-2 px-3 rounded-md focus:outline-none focus:shadow-outline-red text-normal" />
      <button class="ml-2 bg-[#fb7185] hover:bg-[#fb7185] text-white py-2 px-4 rounded-md">Send</button>
    </div>
</div>

