<template>
    <div class="mt-20 mb-20">
        <NavBar />

        <!-- Guild Profile -->
        <div class="flex flex-col items-center p-6">
            <!-- Profile Picture -->
            <div class="relative w-24 h-24">
                <!-- Profile Picture -->
                <img :src="previewPhoto" alt="Profile Picture"
                    class="w-24 h-24 rounded-md border border-gray-300 shadow-md object-cover" />

                <!-- File Input (Hidden) -->
                <input type="file" ref="fileInput" class="hidden" accept="image/*" @change="uploadProfilePhoto" />
            </div>

            <!-- Name & Title -->
            <div class="mt-3 text-center">
                <div class="relative inline-block">
                    <h2 class="text-xl text-[#171A1FFF]">{{ name ?? "--" }}</h2>
                </div>
                <p class="text-[#9095A0FF]">{{ professionalTitle ?? "--" }}</p>
            </div>

            <Ratings />
        </div>

        <!-- Statistics Section -->
        <div class="max-w-lg mx-auto p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl text-[#171A1FFF]">{{ formattedDate }}</h2>
                <span class="text-gray-500 text-sm">Last {{ getLastDaysRange }} days</span>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 gap-3">



                <!-- <DAX :page="'Index'" :user_id="user_id" /> -->


                <button type="button" @click="openDax" v-if="page !== 'Model' && page !== 'GigReport'" class="bg-white min-h-[100px] rounded-[12px] shadow-[rgba(100,100,111,0.2)_0px_7px_29px_0px]
            border p-4 flex flex-col items-center justify-center text-center
             transition-all duration-200 ease-in-out transform hover:scale-105 active:scale-95
             focus:ring-2 focus:ring-gray-300">
                    <div class="flex items-center justify-center space-x-2">
                        <i class="fas fa-headphones-simple text-lg text-[#171A1FFF]"></i>
                        <span class="text-xl font-medium text-[#666666FF]">DAX</span>
                    </div>
                </button>

                <div v-else-if="page === 'GigReport'" @click="openDax" class="bg-white rounded-[12px] shadow-[rgba(100,100,111,0.2)_0px_7px_29px_0px]
             border p-4 flex flex-col items-start cursor-pointer
             transition-all duration-200 ease-in-out transform hover:scale-105 active:scale-95
             focus:ring-2 focus:ring-gray-300">
                    <i class="fas fa-headset text-2xl text-gray-700"></i>
                    <p class="text-sm font-medium mt-2">DAX</p>
                </div>

                <div v-else @click="openDax"
                    class="bg-white shadow-md rounded-lg p-4 flex items-center justify-center mt-6 cursor-pointer">
                    <i class="fas fa-headset text-3xl text-gray-700"></i>
                    <p class="text-sm font-medium ml-2">DAX</p>
                </div>


                <button type="button" @click="goToSchedule()"
                    class="bg-white rounded-[12px] shadow-[rgba(100,100,111,0.2)_0px_7px_29px_0px] border p-4 flex flex-col items-center justify-center text-center transition-all duration-200 ease-in-out transform hover:scale-105 active:scale-95 focus:ring-2 focus:ring-gray-300">

                    <div class="flex items-center justify-center space-x-2">
                        <i class="fas fa-calendar-alt text-lg text-[#232850FF]"></i>
                        <span class="text-xl font-bold text-[#171A1FFF]">
                            {{ this.totalJobBookedToday }}
                        </span>
                    </div>
                    <p class="text-sm text-[#666666FF] mt-1">Jobs Booked Today</p>
                </button>


                <button @click="goToNotification()" type="button"
                    class="bg-white rounded-[12px] shadow-[rgba(100,100,111,0.2)_0px_7px_29px_0px] border p-4 flex flex-col items-start transition-all duration-200 ease-in-out transform hover:scale-105 active:scale-95 focus:ring-2 focus:ring-gray-300">
                    <div class="flex flex-col sm:flex-row items-center sm:space-x-4 space-y-2 sm:space-y-0">
                        <!-- Left Column: Icon and Price stacked vertically -->
                        <div class="flex flex-col items-center">
                            <i class="fas fa-thumbs-up text-xl text-[#171A1FFF]"></i>
                            <div class="text-xl font-bold" v-if="hasFeaturedContent">
                                ${{ parsedFeaturedContent?.gig_price }}
                            </div>
                        </div>

                        <!-- Right Column: Notification description -->
                        <div class="text-center sm:text-left">
                            <div class="text-center sm:text-left">
                                <div class="text-gray-700 leading-snug" v-if="hasFeaturedContent">
                                    {{ parsedFeaturedContent?.initial_issue }}
                                </div>
                                <div class="leading-snug" v-else>
                                    No Latest Notification
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- <p class="text-sm text-gray-500">New Job Request Dryer, no Heat, Stuart</p> -->
                </button>

                <button type="button" @click="goToAnalytics"
                    class="bg-white rounded-[12px] shadow-[rgba(100,100,111,0.2)_0px_7px_29px_0px] border p-4 flex flex-col items-center justify-center text-center transition-all duration-200 ease-in-out transform hover:scale-105 active:scale-95 focus:ring-2 focus:ring-gray-300">

                    <p class="text-sm font-bold text-[#666666FF]">Earnings</p>
                    <div class="flex items-center justify-center space-x-2">
                        <span class="text-xl font-bold text-green-500">${{ this.totalGigPrice }}</span>
                        <i class="fas fa-arrow-up text-green-500 text-sm"></i>
                    </div>
                </button>

            </div>
        </div>

        <!-- Latest Updates Section -->
        <div class="max-w-lg mx-auto p-6">
            <h2 class="text-xl text-[#171A1FFF]">Latest Updates</h2>

            <!-- Loading Spinner -->
            <div v-if="loading" class="flex justify-center items-center h-64">
                <!-- Tailwind CSS spinner -->
                <!-- <svg class="animate-spin h-10 w-10 text-[#171A1FFF]" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg> -->
            </div>

            <div class="space-y-6 mt-3">
                <!-- Show message if no gigs -->
                <div v-if="dataLoaded && Object.keys(groupedUpdates).length === 0" class="text-center text-gray-500">
                    No gig found.
                </div>

                <!-- Loop through dates -->
                <div v-else v-for="(hours, date) in groupedUpdates" :key="date">
                    <h3 class="text-lg font-normal text-[#171A1FFF] mt-4">
                        {{ date }}
                    </h3>
                    <!-- Loop through time slots within each date -->
                    <div v-for="(updates, hour) in hours" :key="hour">
                        <h4 class="text-md font-normal text-[#171A1FFF] mt-2">
                            {{ hour }}
                        </h4>
                        <div class="space-y-4 mt-2">
                            <!-- Loop through each update in that time slot -->
                            <div v-for="(update, index) in updates" :key="index"
                                class="bg-white rounded-[12px] shadow-md shadow-[#171a1f17] drop-shadow-sm border p-4 flex flex-col space-y-2">
                                <div class="flex items-start space-x-3 cursor-pointer" @click="goToGig(update.gig_id)">
                                    <!-- Display image or icon -->
                                    <img v-if="update.image" :src="update.image" class="w-10 rounded-md" />
                                    <i v-else :class="update.icon" class="text-3xl text-gray-700"></i>
                                    <!-- Update content -->
                                    <div class="flex-1">
                                        <h3 class="text-normal text-gray-800">
                                            {{ update.title }}
                                        </h3>
                                        <p class="text-sm text-gray-500">
                                            {{ update.description }}
                                        </p>
                                    </div>
                                </div>

                                <hr class="border-gray-300 my-2" />

                                <!-- Bottom section with icons and expand toggle -->
                                <div class="flex justify-between items-center">
                                    <div class="flex space-x-4 items-center">
                                        <span class="text-green-500 font-bold text-lg flex items-center">${{
                                            update.potentialGigPrice }}</span>
                                        <i class="fas fa-thumbs-up text-xl text-[#171A1FFF]"></i>
                                        <i class="fas fa-play-circle text-xl text-[#171A1FFF]"></i>
                                        <i class="fas fa-info-circle text-xl text-[#171A1FFF]"></i>
                                    </div>
                                    <i @click="toggleExpand(date, hour, index)"
                                        class="fas fa-chevron-down text-xl text-gray-500 cursor-pointer transition-transform duration-300"
                                        :class="{
                                            'rotate-180':
                                                expandedIndex ===
                                                `${date}-${hour}-${index}`,
                                        }"></i>
                                </div>

                                <!-- Expanded details -->
                                <div v-if="
                                    expandedIndex ===
                                    `${date}-${hour}-${index}`
                                " class="mt-2 p-2 rounded-md">
                                    <ul>
                                        <li v-if="
                                            update.machine &&
                                            update.machine.common_repairs
                                        ">
                                            <!-- <span class="text-[#66B2ECFF] cursor-pointer">
                                                <i class="fas fa-info-circle text-xl text-[#171A1FFF]"></i>&nbsp;
                                                {{
                                                firstRepair(
                                                update.machine
                                                .common_repairs
                                                )
                                                }}
                                            </span> -->
                                            <span class="text-[#66B2ECFF] cursor-pointer" @click="goToClient(update)">
                                                <i class="fas fa-info-circle text-xl text-[#171A1FFF]"></i>&nbsp;{{
                                                update.gig.client_name }} {{ update.gig.client_last_name }} - {{
                                                capitalizeWords(update.gig.machine.machine_type) }} {{
                                                capitalizeWords(update.gig.machine.brand_name) }}</span>
                                        </li>
                                        <li v-if="update.youtube_link" class="mt-2">
                                            <a :href="update.youtube_link" target="_blank"
                                                class="cursor-pointer text-[#66B2ECFF]">
                                                <i class="fas fa-play-circle text-xl text-[#171A1FFF]"></i>
                                                {{ update.youtube_link }}
                                            </a>
                                        </li>
                                        <li class="mt-2">
                                            <button type="button" @click="
                                                goToModel(
                                                    update.machine
                                                        .model_number, update.gig_id
                                                )
                                                " class="text-[#66B2ECFF]">
                                                <i class="fas fa-book text-xl text-[#171A1FFF]"></i>
                                                Service Manual
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="max-w-lg mx-auto p-6 text-center">
            <a>
                <i
                    class="fas fa-chevron-down text-xl text-gray-500 cursor-pointer transition-transform duration-300"></i>
            </a>
        </div> -->

        <!-- Latest Updates Section -->
        <div class="max-w-lg mx-auto p-6">
            <h2 class="text-xl font-medium text-[#171A1FFF]">
                Earn While you Learn
            </h2>

            <div class="space-y-4 mt-3">
                <div v-for="(update, index) in earnWhileYouLearn" :key="index"
                    class="bg-white rounded-[12px] shadow-md shadow-[#171a1f17] drop-shadow-sm border p-4 flex flex-col space-y-2">
                    <div class="flex items-start space-x-3">
                        <!-- Image/Icon -->
                        <img v-if="update.image" :src="update.image" class="w-12 h-12 rounded-md" />
                        <i v-else :class="update.icon" class="text-3xl text-gray-700"></i>

                        <!-- Content -->
                        <div class="flex-1">
                            <p class="text-normal font-normal text-gray-800">
                                {{ update.title }}
                            </p>
                            <p class="text-sm text-gray-500">
                                {{ update.description }}
                            </p>
                        </div>
                    </div>

                    <hr class="border-gray-300 my-2" />

                    <!-- Bottom Section: Icons on Left, Arrow Down on Right -->
                    <div class="flex justify-between items-center">
                        <div class="flex space-x-4 items-center">
                            <span class="text-green-500 font-bold text-lg flex items-center">
                                <i class="fas fa-dollar-sign mr-1"></i>
                                {{ update.amount }}
                            </span>
                            <i class="fas fa-thumbs-up text-xl text-[#171A1FFF]"></i>
                            <i class="fas fa-play-circle text-xl text-[#171A1FFF]"></i>
                            <i class="fas fa-info-circle text-xl text-[#171A1FFF]"></i>
                        </div>

                        <!-- Toggle Arrow -->
                        <i @click="toggleExpandV2(index)"
                            class="fas fa-chevron-down text-xl text-gray-500 cursor-pointer transition-transform duration-300"
                            :class="{ 'rotate-180': expandedIndexV2 === index }"></i>
                    </div>

                    <!-- Expanded Content -->
                    <div v-if="expandedIndexV2 === index" class="mt-2 p-2 bg-gray-100 rounded-md">
                        <p class="text-sm text-gray-700">
                            This is additional information about "{{
                            update.title
                            }}". You can add more details here.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-lg mx-auto p-6 text-center">
            <a>
                <i
                    class="fas fa-chevron-down text-xl text-gray-500 cursor-pointer transition-transform duration-300"></i>
            </a>
        </div>

        <BottomNav />
    </div>
</template>

<script>
import NavBar from "../sections/Navbar.vue";
import Ratings from "../sections/Ratings.vue";
import BottomNav from "../sections/Bottombar.vue";
import { bus } from '../sections/DAX.vue';
import axios from "axios"; // Ensure axios is imported

export default {
    components: { NavBar, BottomNav, Ratings },
    name: "DashboardIndex",
    data() {
        return {
            loading: false,
            dataLoaded: false,
            serviceManual: [],
            noServiceManualMessage: null,
            expandedIndex: null,
            expandedIndexV2: null,
            previewPhoto: "/images/avatar.png",

            user_id: null,
            total_jobs: 0,
            name: "--",
            professionalTitle: "--",
            latestUpdates: [],
            earnWhileYouLearn: [
                {
                    image: "../../../../images/earn-while-you-learn.png",
                    title: "Dryer Repair: Squeaking, Squealing, Thu..",
                    description: "First 75 days 1 hours",
                    amount: "100",
                },
                {
                    image: "../../../../images/earn-while-you-learn.png",
                    title: "Dryer Repair: Squeaking, Squealing, Thu..",
                    description: "First 75 days 1 hours",
                    amount: "300",
                },
            ],
            gigHistoryData: [], // Store the fetched gig history
            loadingGigHistory: true, // Loading state
            totalGigPrice: 0.0,
            totalJobBookedToday: 0,
            latestNotif: {
                type: Object,
                default: null
            },
            selectedDate: new Date().toISOString().substr(0, 10),
            selectedTime: new Date().toISOString().substr(11, 5),
        };
    },
    mounted() {
        const date = new Date();
        const options = { month: "long", day: "numeric" };
        // this.formattedDate = date.toLocaleDateString("en-US", options);

        // Check if token exists in URL
        const urlParams = new URLSearchParams(window.location.search);
        const tokenFromUrl = urlParams.get('token');

        if (tokenFromUrl) {
            localStorage.setItem('token', tokenFromUrl);
        }
    },
    computed: {
        page() {
            return this.$route.name;
        },
        groupedUpdates() {
            return this.latestUpdates.reduce((groups, update) => {
                // Convert rawTime to a proper ISO UTC format if needed.
                // For example, if the rawTime is "2025-04-03 10:20:30", convert it to "2025-04-03T10:20:30Z"
                let rawTime = update.rawTime;
                if (rawTime && rawTime.indexOf("T") === -1) {
                    rawTime = rawTime.replace(" ", "T") + "Z";
                }
                const updateDate = new Date(rawTime);
                if (isNaN(updateDate)) {
                    console.error("Invalid date:", update.rawTime);
                    return groups;
                }
                // Group by UTC date: "Month Day" (e.g., "April 4")
                const dateStr = updateDate.toLocaleDateString("en-US", {
                    timeZone: "UTC",
                    month: "long",
                    day: "numeric",
                });
                // Group by UTC time: "h:mm AM/PM" (e.g., "5:00 AM")
                const timeStr = updateDate.toLocaleTimeString("en-US", {
                    timeZone: "UTC",
                    hour: "numeric",
                    minute: "2-digit",
                    hour12: true,
                });
                if (!groups[dateStr]) {
                    groups[dateStr] = {};
                }
                if (!groups[dateStr][timeStr]) {
                    groups[dateStr][timeStr] = [];
                }
                groups[dateStr][timeStr].push(update);
                return groups;
            }, {});
        },
        parsedFeaturedContent() {
            if (this.latestNotif && this.latestNotif.featured_content) {
                // If it's already an object, return it directly.
                if (typeof this.latestNotif.featured_content === 'object') {
                    return this.latestNotif.featured_content;
                }
                // Otherwise, try parsing it as JSON.
                try {
                    return JSON.parse(this.latestNotif.featured_content);
                } catch (error) {
                    console.error("Failed to parse featured_content JSON:", error);
                    return {};
                }
            }
            return {};
        },
        hasFeaturedContent() {
            // Check that we have valid data (non-empty object) and that latestNotif exists.
            return (
                this.latestNotif &&
                this.latestNotif.featured_content &&
                Object.keys(this.parsedFeaturedContent).length > 0
            );
        },
        formattedDate() {
            if (this.selectedDate) {
                // Append time to ensure correct UTC parsing if the value is in "YYYY-MM-DD" format
                const date = new Date(this.selectedDate + "T00:00:00Z");
                const options = {
                    month: "long",
                    day: "numeric",
                    timeZone: "UTC",
                };
                return new Intl.DateTimeFormat("en-US", options).format(date);
            } else {
                // Default to today's date if no date is selected
                const today = new Date();
                const options = {
                    month: "long",
                    day: "numeric",
                    timeZone: "UTC",
                };
                return new Intl.DateTimeFormat("en-US", options).format(today);
            }
        },
        getLastDaysRange() {
            const today = new Date();
            return today.getDate() - 1; // Subtracting 1 because we don't count today itself
        },
    },
    created() {
        this.fetchUserData().then(() => {
            this.gigHistory(); // Now it will have the correct user_id
        });
    },

    methods: {
        goToNotification() {
            this.$router.push("/notification");
        },
        goToAnalytics() {
            this.$router.push("/analytics");
        },
        capitalizeWords(str) {
            if (!str) return ""; // Return an empty string if str is undefined/null
            return str.replace(/\b\w/g, (char) => char.toUpperCase());
        },
        toggleExpand(date, time, index) {
            // Convert time & index into a unique identifier
            const itemKey = `${date}-${time}-${index}`;

            // If the clicked item is already open, close it
            // Otherwise, close all and open the clicked one
            this.expandedIndex =
                this.expandedIndex === itemKey ? null : itemKey;
        },
        toggleExpandV2(index) {
            this.expandedIndexV2 =
                this.expandedIndexV2 === index ? null : index;
        },
        goToGig(id) {
            this.$router.push(`/gig/${id}`);
        },
        goToSchedule() {
            this.$router.push(`/schedules`);
        },
        goToModel(modelNumber, gig_id) {
            this.$router.push(`/model/${modelNumber}/gig/${gig_id}`);
        },
        goToNotification() {
            this.$router.push(`/notification`);
        },
        async gigHistory() {
            try {
                const api_endpoint = import.meta.env.VITE_API_ENDPOINT;
                const token = import.meta.env.VITE_API_KEY;

                // console.log("Fetching Gig History...");

                // console.log("User ID: " + this.user_id);

                const payload = {
                    techID: this.user_id, // Replace with dynamic techID if needed
                    current_datetime: new Date()
                        .toISOString()
                        .slice(0, 19)
                        .replace("T", " "),
                    total_records: 5, // Limit to 5
                };

                if (this.selectedDate) {
                    payload.date = this.selectedDate;
                }


                // alert(this.selectedDate);
                // if (this.selectedDate) {
                //     payload.date = this.selectedDate; // Add selected date to request if available
                // }

                // if (this.selectedTime) {
                //     payload.time = this.selectedTime;
                // }


                const response = await axios.post(
                    `${api_endpoint}/gigs/retrieveGigByTechID.php`,
                    payload, // Passing techID in the request body
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                            "Content-Type": "application/json",
                        },
                    }
                );

                this.gigHistoryData = response.data.data || []; // Store fetched data

                // Set this to allow DAX access all current & upcoming gigs
                this.$store.commit("setGigHistory", this.gigHistoryData);

                this.loadingGigHistory = false; // Stop loading

                if (this.gigHistoryData.length > 0) {
                    
                    this.totalJobBookedToday = this.gigHistoryData.length;

                    const gigOpenAIObject = [];

                    // Transform data for latestUpdates
                    this.latestUpdates = this.gigHistoryData.map((gig) => {
                        // Adjust rawTime if needed. For example, convert "YYYY-MM-DD HH:mm:ss" to ISO "YYYY-MM-DDTHH:mm:ssZ"
                        let rawTime = gig.start_datetime;
                        if (rawTime && rawTime.indexOf("T") === -1) {
                            rawTime = rawTime.replace(" ", "T") + "Z";
                        }

                        // Determine upsell availability: upsell is available if the client is missing one or both plans.
                        const hasUpsellPotential = !(gig.insurance_plan && gig.maintenance_plan);

                        // Determine the basic rate based on technician rank
                        const basic_rate = gig.tech_rank_type === "0" ? 40.00 : 50.00;

                        // Empty the earnings array
                        this.gigPotentialEarnings = [];

                        // First-time visit logic
                        if (gig.gig_type == "0") {
                            // Diagnostic only scenario
                            this.gigPotentialEarnings.push({ name: "Diagnostic only", amount: basic_rate });
                            // Diagnostic + Upsell scenario (only if upsell is applicable)
                            if (hasUpsellPotential) {
                                this.gigPotentialEarnings.push({ name: "Diagnostic + upsell", amount: basic_rate + 25.00 });
                            }
                            // Full repair onsite scenario (which is equivalent to doing both diagnostic and repair in one visit)
                            this.gigPotentialEarnings.push({ name: "Full repair onsite", amount: basic_rate * 2 });
                            // Full repair onsite with upsell (if upsell is applicable)
                            if (hasUpsellPotential) {
                                this.gigPotentialEarnings.push({ name: "Full repair onsite + upsell", amount: (basic_rate * 2) + 25.00 });
                            }
                        }
                        // Return visit logic
                        else if (gig.gig_type == "1") {
                            // Return repair scenario
                            this.gigPotentialEarnings.push({ name: "Return repair", amount: basic_rate });
                            // Return repair with upsell scenario (if upsell is applicable)
                            if (hasUpsellPotential) {
                                this.gigPotentialEarnings.push({ name: "Return repair + upsell", amount: basic_rate + 25.00 });
                            }
                        }

                        // Calculate the potential gig price by summing the amounts of all scenarios
                        // const potentialGigPrice = this.gigPotentialEarnings.reduce((total, item) => total + item.amount, 0);
                        let potentialGigPrice = 0.00;
                        if (this.gigPotentialEarnings.length > 0) {
                            potentialGigPrice = Math.max(...this.gigPotentialEarnings.map(item => item.amount));
                        }



                        // {gigID: 11, gigTime: 1:30pm, gigID: ja5-unk, gigClient: Client Name} from Jacob
                        gigOpenAIObject.push({
                            gigID: gig.gig_id,
                            gigTime: this.formatTo12Hour(gig.start_datetime),
                            gigCryptic: gig.gig_cryptic,
                            gigClient: `${gig.client_name} ${gig.client_last_name}`
                        });

                        return {
                            gig_id: gig.gig_id, 
                            rawTime: rawTime, // Save the raw datetime in ISO UTC format
                            image: gig.machine.machine_photo
                                ? gig.machine.machine_photo
                                : "../../../../images/washing-machine.png", // Keeping static image
                            title: `Gig #${this.capitalizeWords(gig.gig_cryptic)} - ${this.capitalizeWords(gig.machine.brand_name)} ${this.capitalizeWords(gig.machine.machine_type)}`,
                            description: gig.initial_issue || "No issue description available.",
                            amount: `$${gig.gig_price}`, // Format price
                            repair_notes: `${gig.repair_notes}`,
                            machine: gig.machine,
                            youtube_link: gig.youtube_link,
                            potentialGigPrice: potentialGigPrice,  // New custom field
                            gig:gig
                        };
                    });

                    this.totalGigPrice = this.latestUpdates.reduce(
                        (sum, gig) => sum + parseFloat(gig.potentialGigPrice || 0.00),
                        0.0
                    );


                    this.$store.commit("setGigOpenAIObject", gigOpenAIObject);


                } else {
                    this.latestUpdates = []; // Set to empty array if no data
                }


            } catch (error) {
                console.error("Error fetching gig history data:", error);
                this.loadingGigHistory = false;
            } finally {
                this.loading = false; // stop loading animation after request is finished
                this.dataLoaded = true;
            }
        },
        async fetchUserData() {
            const token = localStorage.getItem("token");
            if (!token) {
                console.error("No token found in localStorage");
                return;
            }
            try {
                const response = await axios.get("/api/user", {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        "Content-Type": "application/json",
                    },
                });

                const userData = response.data.user;

                // Check if profile_photo exists and is valid
                if (
                    userData.profile_photo &&
                    userData.profile_photo !== "null"
                ) {
                    this.previewPhoto = userData.profile_photo.startsWith(
                        "http"
                    )
                        ? userData.profile_photo
                        : `${process.env.VUE_APP_BASE_URL}/storage/${userData.profile_photo}`;
                } else {
                    this.previewPhoto = "/images/avatar.png";
                }

                // Set user info
                this.name = userData.name;
                this.professionalTitle = userData.professional_title;
                this.user_id = userData.id;
                this.total_jobs = response.data.total_jobs_booked;
                this.latestNotif = response.data.latest_notif;
            } catch (error) {
                console.error("Error fetching user data:", error);
            }
        },

        goToRepair(data, gig_id) {
            try {
                const repairs = JSON.parse(data);
                const id = Array.isArray(repairs) && repairs.length > 0
                    ? `${repairs[0].id}`
                    : '#';

                this.$router.push(`/gig/${gig_id}/repair/${id}`);
            } catch (e) {

                this.$router.push(`/dashboard#`);
            }
        },
        firstRepair(data) {
            try {
                const repairs = JSON.parse(data);
                return Array.isArray(repairs) && repairs.length > 0
                    ? `${repairs[0].repairName} - ${repairs[0].solution}`
                    : null;
            } catch (e) {
                return null;
            }
        },
        goToClient(data) {
            this.$router.push(`/customer/${data.gig.client_id}/gig/${data.gig_id}`);
        },

        formatTo12Hour(timeString) {
            const date = new Date(timeString.replace(" ", "T")); // Local time
            return date.toLocaleTimeString("en-US", {
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            }).toLowerCase();
        },
        openDax() {
            bus.emit('open-dax');
            console.log(`open`);
        }
    },
};
</script>
