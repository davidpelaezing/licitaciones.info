<template>
    <div class="row">
        <div class="col-md-11 mx-auto">
            <div class="card">
                <div class="card-body">
                    <!-- Table -->
                    <ListarTagsComponent />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import ListarTagsComponent from '../components/tag/ListarTagsComponent';
export default {

components: {
    ListarTagsComponent,
},

}

</script>