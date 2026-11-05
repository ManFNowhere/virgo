<div id="play-modal" class="hidden bg-gray-900 z-100 fixed">
    <video id="video-trailer" class="lg:w-3/4 p-2 h-full mx-auto my-20" controls>
        <source src="{{ url($data['trailer']) }}" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>
    <button id="exit-button" class="text-gray-900 hover:text-white hover:bg-gray-800 rounded-lg p-2 absolute top-10 right-5 lg:right-40 xl:right-50 text-xl flex items-center"><p class="mr-2">Exit</p> <i class="fa-solid fa-xmark text-white"></i></button>
</div>


