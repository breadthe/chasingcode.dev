<template>
    <div class="flex flex-1 justify-end items-center text-right pl-4 sm:pr-4">
        <div
            class="absolute sm:relative w-full justify-end top-0 left-0 z-20 py-4 sm:py-0 px-4 sm:px-0 bg-gray-50"
            :class="{'hidden sm:flex': ! searching}"
        >
            <label for="search" class="hidden">Search</label>

            <input
                id="search"
                v-model="query"
                ref="search"
                class="transition-fast h-10 w-full sm:w-1/2 sm:focus:w-3/4 border focus:border-teal-400 outline-none cursor-pointer px-4 shadow-inner"
                :class="{ 'transition-border': query }"
                autocomplete="off"
                name="search"
                placeholder="Search posts"
                type="text"
                aria-label="Search the blog"
                @keyup.esc="reset"
                @blur="reset"
            >

            <button
                v-if="query || searching"
                class="absolute top-0 right-0 leading-snug font-light text-3xl text-gray-500 hover:text-gray-600 focus:outline-none inset-y-0 pr-6 sm:pr-2"
                @click="reset"
            >&times;</button>

            <transition name="fade">
                <div v-if="query" class="absolute top-0 inset-x-0 sm:inset-auto w-full lg:w-3/4 text-left mb-4 mt-16 sm:mt-12">
                    <div class="flex flex-col bg-white border border-b-0 border-t-0 border-teal-400 rounded-b-lg shadow-lg mx-4 sm:mx-0">
                        <a
                            v-for="(result, index) in results"
                            class="group bg-white hover:bg-gray-100 border-b border-teal-400 cursor-pointer p-4"
                            :class="{ 'rounded-b-lg' : (index === results.length - 1) }"
                            :href="result.item.link"
                            :title="result.item.title"
                            :key="result.link"
                            @mousedown.prevent
                        >
                            <h2 class="font-serif text-xl leading-snug text-teal-700 group-hover:text-teal-900">{{ result.item.title }}</h2>

                            <span class="block font-sans font-normal text-gray-600 group-hover:text-black text-sm my-1" v-html="result.item.snippet"></span>
                        </a>

                        <div
                            v-if="! results.length"
                            class="bg-white w-full hover:bg-gray-100 border-b border-teal-400 rounded-b-lg shadow cursor-pointer p-4"
                        >
                            <p class="my-0">No results for <strong>{{ query }}</strong></p>
                        </div>
                    </div>
                </div>
            </transition>
        </div>

        <button
            title="Start searching"
            type="button"
            class="flex sm:hidden items-center bg-white border rounded focus:outline-none w-full h-10 pl-2"
            @click.prevent="showInput"
        >
            <!--
            Formerly <img src="/assets/images/magnifying-glass.svg" alt="search icon" class="h-4 w-4 max-w-none">
            -->
            <svg
                class="h-4 w-8"
                :class="{ 'text-white': !belongsToBlog }"
                width="13px"
                height="13px"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
            >
                <defs></defs>
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g
                        transform="translate(-829.000000, -42.000000)"
                        :fill="svgFill"
                        fill-rule="nonzero"
                    >
                        <path d="M843.319857,54.9056439 L848.707107,60.2928932 C849.097631,60.6834175 849.097631,61.3165825 848.707107,61.7071068 C848.316582,62.0976311 847.683418,62.0976311 847.292893,61.7071068 L841.905644,56.3198574 C840.55096,57.3729184 838.848711,58 837,58 C832.581722,58 829,54.418278 829,50 C829,45.581722 832.581722,42 837,42 C841.418278,42 845,45.581722 845,50 C845,51.8487115 844.372918,53.5509601 843.319857,54.9056439 Z M837,56 C840.313708,56 843,53.3137085 843,50 C843,46.6862915 840.313708,44 837,44 C833.686292,44 831,46.6862915 831,50 C831,53.3137085 833.686292,56 837,56 Z" id="Mask"></path>
                    </g>
                </g>
            </svg>
          <span class="text-gray-400">Search</span>
        </button>
    </div>
</template>

<script>
import Fuse from 'fuse.js';

export default {
    props: {
        dataBelongsToBlog: {
            type: String,
            required: true,
            default: '',
        }
    },
    data() {
        return {
            fuse: null,
            searching: false,
            query: '',
            belongsToBlog: this.dataBelongsToBlog === '1' || false,
        };
    },
    computed: {
        results() {
            return this.query ? this.fuse.search(this.query) : [];
        },
        svgFill() {
            return '#748294'; // text-gray-600
        }
    },
    methods: {
        showInput() {
            this.searching = true;
            this.$nextTick(() => {
                this.$refs.search.focus();
            })
        },
        reset() {
            this.query = '';
            this.searching = false;
        },
    },
    created() {
        axios('/index.json').then(response => {
            this.fuse = new Fuse(response.data, {
                minMatchCharLength: 4,
                keys: ['title', 'snippet', 'tags'],
            });
        });
    },
};
</script>

<style>
input[name='search'] {
    background-image: url('/assets/images/magnifying-glass.svg');
    background-position: 0.8em;
    background-repeat: no-repeat;
    border-radius: 4px;
    text-indent: 1.2em;
}

input[name='search'].transition-border {
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
    /*border-top-left-radius: .5rem;*/
    /*border-top-right-radius: .5rem;*/
}

.fade-enter-active {
    transition: opacity .5s;
}

.fade-leave-active {
    transition: opacity 0s;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}
</style>
