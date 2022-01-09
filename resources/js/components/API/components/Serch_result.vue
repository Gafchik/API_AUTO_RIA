<template>
<div class="w">
    <!--          бежим по id -->
    <div id="t" v-for="(ids,i) in result">
        <!--              бежим по машинам-->
        <div  class="card w-75"  v-for="(car,i2) in ids" >
            <div class="card-body">
                <h5 class="card-title">{{car['markName']}}</h5>
                <div :id="'carouselExampleControls'+i" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <!--                           бежим по картинками-->
                        <div v-for="(img,index) in car['imgArr']" :class="{ active: index==0 }" class="carousel-item">
                            <img :src="'https://cdn3.riastatic.com/photosnew/auto/photo/volkswagen_passat-b7__'+img+'b.jpg'"
                                 class="d-block w-100 mh-75" alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" :data-bs-target="'#carouselExampleControls'+i"  data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Предыдущий</span>
                    </button>
                    <button class="carousel-control-next" type="button" :data-bs-target="'#carouselExampleControls'+i"  data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Следующий</span>
                    </button>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">модель : {{car['modelName']}}</li>
                    <li class="list-group-item">город : {{car['locationCityName']}}</li>
                    <li class="list-group-item">цена : {{car['price']}} $</li>
                    <li class="list-group-item">цвет : {{car['color']}}</li>
                    <li class="list-group-item">тип кузова : {{car['subCategoryName']}}</li>
                    <li class="list-group-item">год выпуска : {{car['year']}}</li>
                    <li class="list-group-item">пробег : {{car['race']}}</li>
                    <li class="list-group-item">описание : {{car['description']}}</li>
                </ul>
                <br>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
export default {
    name: "Serch_result",
    computed: {
        ...mapGetters('serch', ['result']),
    },
}
</script>

<style scoped>
#t{
    margin-left: 200pt;
    margin-bottom: 30pt;
}
</style>
