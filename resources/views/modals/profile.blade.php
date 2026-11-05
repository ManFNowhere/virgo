<div id="profile-modal" class="z-10 hidden lg:hidden  p-10">
    <ul class="w-full flex flex-col min-h-40 justify-evenly">
        <li>
            <a href="dashboard" class="text-2xl text-white"><i class="fa-solid fa-gear mx-4"></i>Dashboard</a>
        </li>
        <li>
            <form action="{{ url('/logout') }}" method="post">
                @csrf
                <button type="submit" class="text-2xl text-white">
                <i class="fa-solid fa-right-from-bracket mx-4"></i>
                Sign out
                </button>
            </form>
        </li>
    </ul>
</div>