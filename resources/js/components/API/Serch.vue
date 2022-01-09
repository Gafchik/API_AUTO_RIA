<template>
<div>
    <v-app id="inspire">
        <v-container fluid>
            <Serch_form></Serch_form>
            <hr>
            <Serch_result></Serch_result>
        </v-container>
    </v-app>
</div>
</template>

<script>

export default {
    name: "Serch",
    components:{
        Serch_form: () => import('./components/Serch_form'),
        Serch_result: () => import('./components/Serch_result'),
    },


}
</script>

<style scoped>

</style>
