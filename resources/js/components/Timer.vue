<template>
    <div class="all_time">
        <div class="timer" v-if="years != 0"><span class="number">{{years}}</span><span class="text">{{yearsName}}</span></div>
        <div class="timer"><span class="number">{{month}}</span><span class="text">{{monthName}}</span></div>
        <div class="timer"><span class="number">{{days}}</span><span class="text">{{daysName}}</span></div>
        <div class="timer"><span class="number">{{hours}}</span><span class="text">{{hoursName}}</span></div>
        <div class="timer"><span class="number">{{minute}}</span><span class="text">{{minuteName}}</span></div>
        <div class="timer"><span class="number">{{second}}</span><span class="text">{{secondName}}</span></div>
    </div>
</template>

<script>
    export default {
        name: "Timer.vue",
        data() {
            return {
                nowDate: null,
            }
        },
        computed: {
            startDate() {
                return new Date(2019, 0, 23).getTime();
            },
            diffDate() {
                return new Date(Math.abs(this.nowDate - this.startDate));
            },
            years() {
                return this.diffDate.toISOString().slice(0, 4) - 1970;
            },
            month() {
                return this.diffDate.getMonth();
            },
            days() {
                return this.diffDate.getDate() - 1;
            },
            hours() {
                return this.diffDate.getUTCHours();
            },
            minute() {
                return this.diffDate.getMinutes();
            },
            second() {
                return this.diffDate.getSeconds();
            },
            secondName() {
                return this.declOfNum(this.second, ['секунда', 'секунды', 'секунд']);
            },
            minuteName() {
                return this.declOfNum(this.minute, ['минута', 'минуты', 'минут']);
            },
            hoursName() {
                return this.declOfNum(this.hours, ['час', 'часа', 'часов']);
            },
            daysName() {
                return this.declOfNum(this.days, ['день', 'дня', 'дней']);
            },
            monthName() {
                return this.declOfNum(this.month, ['месяц', 'месяца', 'месяцев']);
            },
            yearsName() {
                return this.declOfNum(this.years, ['год', 'года', 'лет']);
            }
        },
        methods: {
            declOfNum(number, titles) {
                let cases = [2, 0, 1, 1, 1, 2];
                return titles[ (number%100>4 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];
            }
        },
        created() {
            var self = this;
            setInterval(function () {
                self.nowDate = new Date().getTime();
            }, 1000);
        }
    }
</script>

<style scoped>
    .timer {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border-right: 1px solid black;
        padding-right: 1vw;
        margin-right: 1vw;
    }
    .timer:last-child {
        border: none;
    }
    .timer .number {
        font-size: 3rem;
    }
    .timer .text {
        font-size: 1rem;
        font-style: italic;
        font-family: 'Exo 2', sans-serif;
    }
    .all_time {
        display: flex;
        flex-direction: row;
    }
</style>
