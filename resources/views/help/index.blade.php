<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Help Center') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Welcome to the Help Center</h3>
                    <p class="mb-4">Here you can find guides and support for using the Internship Management System.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div class="p-4 border rounded-lg hover:border-red-500 transition">
                            <h4 class="font-bold text-gray-800">For Admins</h4>
                            <ul class="list-disc list-inside mt-2 text-sm text-gray-600">
                                <li>How to add new users</li>
                                <li>Managing divisions</li>
                                <li>Monitoring internships</li>
                            </ul>
                        </div>
                        
                        <div class="p-4 border rounded-lg hover:border-red-500 transition">
                            <h4 class="font-bold text-gray-800">For Mentors</h4>
                            <ul class="list-disc list-inside mt-2 text-sm text-gray-600">
                                <li>Approving logbooks</li>
                                <li>Grading interns</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-8 text-center text-sm text-gray-500">
                        <p>Need more help? Contact support at <span class="font-bold">cs@telkomsel.com</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
