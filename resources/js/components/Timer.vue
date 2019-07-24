<template>
    <div></div>
</template>

<script>
    export default {
        name: "Timer.vue",
        data() {
            return {
                years: null,
                month: null,
                days: null,
                hours: null,
                minute: null,
                second: null
            }
        },
        methods: {
            startInterval() {
                setInterval(this.updateTime, 1000);
            },
            updateTime() {
                
                var nowMS = Date.now().getTime();
                nowMS += 1000;


            }
        }
    }
</script>

<style scoped>

</style>
