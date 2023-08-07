<div class="modal fade" id="exampleModaldd" tabindex="-1"
aria-labelledby="exampleModalLabel" aria-hidden="true" style="direction: rtl">
<div class="modal-dialog ">
    <div class="modal-content">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="btns">
                    <!-- <button type="button" class="btn btn-primary">select files</button> -->
                </div>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab"
                            href="#home" role="tab" aria-controls="home"
                            aria-selected="true">رفع صورة</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab"
                            href="#profile" role="tab" aria-controls="profile"
                            aria-selected="false">عرض الصور</a>
                    </li>

                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home"
                        role="tabpanel" aria-labelledby="home-tab">
                        <form action="" class="mt-4 mb-4" id="uploadimage_modal"
                            style="text-align: center">
                            <p>رفع ملفات</p>
                            <input type="file" class="image"
                                id="imageuploadmodal" onchange="myFunction()">
                            <div class="form-group">
                                <img src="" style="width: 100px"
                                    class="img-thumbnail image-preview"
                                    alt="">
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel"
                        aria-labelledby="profile-tab" style="display: flex">

                        <div class="main-content ">
                            <div class="row  blogsimage">

                                @include('dashboard.blogs.all_image')
                            </div>
                        </div>

                        <div class="img-info col-md-3" style="display: none">
                            <h5>image info</h5>
                            <p> </p>
                            <form action="" id="uplodimageinfo">
                                <label for="" class="mb-2">Alt iamge</label>
                                <input type="hidden" name=""
                                    class="form-control mb-3" id="image_id_info" />
                                <input type="text" name=""
                                    class="form-control mb-3" id="alt_image" />
                                <label for="" class="mb-2">Title</label>
                                <input type="text" name=""
                                    class="form-control mb-3" v-model="image.imgTitle"
                                    id="title_image" />
                                <label for=""
                                    class="mb-2">Description</label>
                                <textarea name="" id="description_image" cols="30" class="form-control mb-3" rows="10"
                                    v-model="image.imgDescription"></textarea>

                                <button class="btn btn-primary"
                                    onclick="storedata_image()" type="button">
                                    حفظ
                                </button>

                            </form>

                        </div>
                    </div>
                </div>



            </div>

        </div>
    </div>

</div>
</div>