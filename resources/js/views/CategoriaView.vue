<template>
    <div class="row">
        <div class="col-md-11 mx-auto">
            <div class="card">
                <div class="card-body">
                    <!-- Table -->
                    <ListarCategoriasComponent />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import ListarCategoriasComponent from '../components/categoria/ListarCategoriasComponent';
export default {

components: {
    ListarCategoriasComponent,
},

}

</script>