{HEADER}
<style>
    .profile-picture {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
    }
</style>
<div class="container mt-5">
    <div class="row mb-5">
        <div class="col-md-4">
            <img src="{PROFILE_PICTURE}" alt="Profile Picture" class="profile-picture" >
        </div>
        <form action="../photoprofile.php" enctype="multipart/form-data" method="post">
            <label for="file">Прикрепить файл:</label>
            <input type="file" name="file" id="file">
            <input value="Отправить" type="submit">
        </form>
        <div class="col-md-8">
            <h4>{USERNAME}</h4>
            <p>{EMAIL}</p>
        </div>
    </div>

    <div class="card mb-5">
        <div class="card-header">
            <ul class="nav nav-tabs" id="Tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="myPosts-tab" data-bs-toggle="tab" data-bs-target="#myPosts" type="button" role="tab" aria-controls="myPosts" aria-selected="true">Мои статьи</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="newPost-tab" data-bs-toggle="tab" data-bs-target="#newPost" type="button" role="tab" aria-controls="newPost" aria-selected="false">Новая статья</button>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="TabsContent">
                <!-- Вкладка "Мои статьи" -->
                <div class="tab-pane fade show active" id="myPosts" role="tabpanel" aria-labelledby="myPosts-tab">
                    {POST}
                </div>

                <!-- Вкладка "Новая статья" -->
                <div class="tab-pane fade" id="newPost" role="tabpanel" aria-labelledby="newPost-tab">
                    <form method="post" action="../newpost.php">
                        <div class="mb-3">
                            <label for="registerName" class="form-label">Название статьи</label>
                            <input type="text" name="title" class="form-control" id="registerName" required>
                        </div>
                        <div class="dropdown mb-3">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="categoryDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                Выбрать категорию
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                                <li><a class="dropdown-item" href="#" onclick="selectCategory(this)">{CATEGORY}</a></li>
                            </ul>
                            <input type="hidden" id="selectedCategory" name="category" required>
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label">Текст статьи</label>
                            <textarea class="form-control" name="content" rows="3" placeholder="Текст статьи" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Добавить</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

{FOOTER}
