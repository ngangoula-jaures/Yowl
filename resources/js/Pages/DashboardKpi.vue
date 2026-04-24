<script setup>
import Chart from 'primevue/chart';
import { ref, onMounted } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';
import Navbar from '@/Layouts/Navbar.vue';
defineOptions({
  layout: Navbar,
});

onMounted(() => {
    chartData.value = setChartData();
    chartOptions.value = setChartOptions();
    chartDognutData.value = setChartDognutData();
    chartDognutOptions.value = setChartDognutOptions();
});

const props= defineProps({
    chartData: Object,
    chartDognutDatas: Object,
    count: Object
})

const chartData = ref();
const chartOptions = ref();

const setChartData = () =>  {
    const documentStyle = getComputedStyle(document.documentElement);

    return {
        labels: props.chartData['days'],
        datasets: [
            {
                type: 'bar',
                label: 'Utilisateurs',
                backgroundColor: 'blue',
                data: props.chartData['usersNumber']
            },
            {
                type: 'bar',
                label: 'Posts',
                backgroundColor: 'purple',
                data: props.chartData['postsNumber']
            },
            {
                type: 'bar',
                label: 'Commentaires',
                backgroundColor: 'orange',
                data: props.chartData['commentsNumber']
            }
        ]
    };
};
const setChartOptions = () =>  {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue('--text-color');
    const textColorSecondary = documentStyle.getPropertyValue('--text-color-secondary');
    const surfaceBorder = documentStyle.getPropertyValue('--surface-border');

    return {
        maintainAspectRatio: false,
        aspectRatio: 0.8,
        plugins: {
            tooltips: {
                mode: 'index',
                intersect: false
            },
            legend: {
                labels: {
                    color: 'gray'
                }
            }
        },
        scales: {
            x: {
                stacked: true,
                ticks: {
                    color: 'black'
                },
                grid: {
                    display: false
                }
            },
            y: {
                stacked: true,
                ticks: {
                    color: 'black'
                },
                grid: {
                    display: false
                }
            }
        }
    };
}


const chartDognutData = ref();
const chartDognutOptions = ref(null);

const setChartDognutData = () => {
    const documentStyle = getComputedStyle(document.body);

    return {
        labels: props.chartDognutDatas['domains'],
        datasets: [
            {
                data: props.chartDognutDatas['ratio'],
                backgroundColor: ['blue', 'orange', 'green', 'cyan', 'red'],
                hoverBackgroundColor: ['blue', 'orange', 'green', 'cyan', 'red']
            }
        ]
    };
};

const setChartDognutOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue('--text-color');

    return {
        plugins: {
            legend: {
                labels: {
                    cutout: '60%',
                    color: 'gray'
                }
            }
        }
    };
};

</script>

<template>
    <div class="min-h-screen p-6 md:p-10 font-sans text-[rgba(255,255,255,0.92)]">
        <!-- Header -->
        <header class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight text-white">Admin Dashboard</h1>
                <p class="text-[rgba(255,255,255,0.6)] mt-1">Gérez et analysez les performances de Yowl.</p>
            </div>

            <div class="flex items-center gap-4">
                <Link :href="route('admin.index')"><button class="yowl-btn text-sm px-3 py-2">Administrer Yowl</button></Link>
            </div>
        </header>

        <!-- KPI Cards Grid -->
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Card 1 -->
            <div class="yowl-card relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-sm font-semibold text-[rgba(255,255,255,0.6)] uppercase tracking-wider mb-2">Total Utilisateurs</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-extrabold text-white">{{ props.count.userCount }}</span>
                    <span class="text-sm font-medium text-emerald-300 bg-[rgba(52,211,153,0.06)] px-2 py-0.5 rounded-full flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        +12%
                    </span>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="yowl-card relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11l3 3L22 4" />
                    </svg>
                </div>
                <h3 class="text-sm font-semibold text-[rgba(255,255,255,0.6)] uppercase tracking-wider mb-2">Total Posts</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-extrabold text-white">{{ props.count.postCount }}</span>
                    <span class="text-sm font-medium text-emerald-300 bg-[rgba(52,211,153,0.06)] px-2 py-0.5 rounded-full flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        +5.2%
                    </span>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="yowl-card relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </div>
                <h3 class="text-sm font-semibold text-[rgba(255,255,255,0.6)] uppercase tracking-wider mb-2">Total Commentaires</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-extrabold text-white">{{ props.count.commentCount }}</span>
                    <span class="text-sm font-medium text-rose-300 bg-[rgba(255,92,92,0.06)] px-2 py-0.5 rounded-full flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                        -1.4%
                    </span>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="yowl-card relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>
                <h3 class="text-sm font-semibold text-[rgba(255,255,255,0.6)] uppercase tracking-wider mb-2">Interactions (Likes)</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-extrabold text-white">{{ props.count.likeCount }}</span>
                    <span class="text-sm font-medium text-emerald-300 bg-[rgba(52,211,153,0.06)] px-2 py-0.5 rounded-full flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        +24%
                    </span>
                </div>
            </div>
        </section>

        <!-- Charts Section -->
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
            <!-- Main Chart (Large) -->
            <div class="lg:col-span-2 yowl-card p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-bold text-white">Cette Semaine</h2>
                    <select class="bg-[rgba(255,255,255,0.02)] border border-[rgba(255,255,255,0.04)] text-white text-sm rounded-lg focus:ring-[rgba(199,63,255,0.4)] focus:border-[rgba(199,63,255,0.6)] block p-2">
                        <option>Cette année</option>
                        <option>Ce mois</option>
                        <option>Cette semaine</option>
                    </select>
                </div>
                <div class="w-full h-[350px] bg-white rounded-xl p-4">
                    <Chart type="bar" :data="chartData" :options="chartOptions" class="w-full h-full" />
                </div>
            </div>

            <!-- Secondary Chart (Doughnut / Pie) -->
            <div class="yowl-card p-6">
                <h2 class="text-lg font-bold text-white mb-6">Top Domaines</h2>
                <div class="w-full h-[350px] bg-white rounded-xl p-4">
                    <Chart type="doughnut" :data="chartDognutData" :options="chartDognutOptions" class="w-full h-full" />
                </div>

            </div>
        </section>

        <!-- Bottom Row (Other metrics or Bar Chart) -->
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        </section>
    </div>
</template>
