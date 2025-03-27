SETELAH MENJALANKAN SETIAP COMMAND SEBAIKNYA MELAKUKAN php spark cache:clear 

KALAU INGIN MENGGUNAKAN LIVE SERVER, SEBAIKNYA CI_DEBUG DIBUAT FALSE DI FILE DEVELOPMENT.PHP

Command ModulesGenerate
Penggunaan command ini dengan cara php spark module:generate {namaModule} example = php spark module:generate User
lalu akan menghasilkan folder modules di root direktori kalau belum dibuat lalu folder module nya dengan nama module yang sudah ditentukan.

Command ControllersGenerate
Penggunaan command ini dengan cara php spark module:make-controller {namaModule} {namaModule} example = php spark module:make-controller User User
lalu akan menghasilkan folder Controllers di dalam folder module nya kalau belum dibuat, dan membuat file controller dengan nama yang sesuai dengan {namaModule} dengan format controller default.

Command FiltersGenerate
Penggunaan command ini dengan cara php spark module:make-filter {namaFilter} {namaModule} example = php spark module:make-filter UserFilter User
lalu akan melakukan register filter ke file app/Config/Filters.php dengan key nya sesuai dengan {nameFilter} untuk digunakan sebagai pemanggilan filter nya dan value nya alamat file filter nya dan menghasilkan folder Filters di dalam folder module nya kalau belum dibuat, dan membuat file filter dengan nama yang sesuai dengan {nameFilter} dengan format filter default.

Command HelpersGenerate
Penggunaan command ini dengan cara php spark module:make-helper Helpers {nameModule} example = php spark module:make-helper Helpers User
lalu akan menghasilkan folder Helpers di dalam folder module nya kalau belum dibuat, Command ini tidak menghasilkan file apapun hanya membuat folder Helpers saja dan ketika membuat file helpers nama default nya sebaiknya menggunakan _helper diakhirnya, example user_helper.php lalu pemanggilan file helper nya, bisa dengan include_once ROOTPATH . 'modules/{nameModule}/Helpers/{nameHelper_helper.php}'; example include_once ROOTPATH . 'modules/User/Helpers/user_helper.php';

Command MigrationsGenerate
Penggunaan command ini dengan cara php spark module:make-migration {nameMigration} {nameModule} example php spark module:make-migration User User
lalu akan menghasilkan folder Database di dalam folder module nya kalau belum dibuat, lalu menghasilkan folder Migrations juga di dalam folder Database kalau belum dibuat, dan format nama nya akan menjadi gabungan tanggal dan waktu lalu digabung dengan {nameMigration} example 2024-10-31-143327_User.php dengan format migrations default. Jika ingin digunakan penggunaan nya bisa dengan command php spark migrate:refresh --all untuk menjalankan semua migrasi dan untuk spesifik dengan command php spark migrate -n "Modules\{nameModule}"

Command ModelsGenerate
Penggunaan command ini dengan cara php spark module:make-model {nameModel} {nameModule} example php spark module:make-model UserModel User
lalu akan menghasilkan folder Models di dalam folder module nya kalau belum dibuat, lalu membuat file model nya dengan format model default.

Command ServicesGenerate
Penggunaan command ini dengan cara php spark module:make-service {nameService} {nameModule} example php spark module:make-service UserService User
lalu akan menghasilkan folder Services di dalam folder module nya kalau belum dibuat, lalu membuat file service nya dengan format service default.

Command RepositoryGenerate
Penggunaan command ini dengan cara php spark module:make-repository {nameRepository} {nameModule} example php spark module:make-repository UserRepository User
lalu akan menghasilkan folder Repository di dalam folder module nya kalau belum dibuat, lalu membuat file repository nya dengan format repository default.

Command ModulesList
Penggunaan command ini dengan cara php spark module:list
lalu akan menghasilkan daftar module apa saja yang tersedia.

Command SeedsGenerate
Penggunaan command ini dengan cara php spark module:make-seeder {nameSeeder} {nameModule} example php spark module:make-seeder UserSeeder User
lalu akan menghasilkan folder Database di dalam folder module nya kalau belum dibuat, lalu menghasilkan folder Seeds juga di dalam folder Database kalau belum dibuat dengan format seeder default. Penggunaan seeder selanjutnya harus menggunakan command php spark db:seed {nameSeeder} example php spark db:seed UserSeeder

Command ViewsGenerate
Penggunaan command ini dengan cara php spark module:make-view Views {nameModule} example php spark module:make-view Views User
lalu akan menghasilkan folder Views di dalam folder module nya kalau belum dibuat, lalu menghasilkan 3 folder di dalam Views yaitu : bases, components dan pages sebagai metode modular pemecahan file view 

Command RoutesGenerate
Penggunaan command ini dengan cara php spark module:make-route {nameRoute} {nameModule} example php spark module:make-route ApiUser User
lalu akan menghasilkan folder Routes di dalam folder module kalau belum dibuat, lalu membuat file route nya dengan nama dari {nameRoute} dengan format route default. Lalu akan register juga, path/alamat file route yang baru dibuat di file app/Config/Routes.php

Command RoutesList
Penggunaan command ini dengan cara php spark module:route-list {nameModule} example php spark module:route-list User
lalu akan menghasilkan tabel berisi list route apa saja yang ada di dalam file ApiRoute modulnya.

ConfigGenerate
Penggunaan command ini dengan cara php spark module:make-config {nameModule} example php spark module:make-config User
lalu akan menghasilkan folder Config di dalam {nameModule}

LibrariesGenerate
Penggunaan command ini dengan cara php spark module:make-libraries {nameModule} example php spark module:make-libraries User
lalu akan menghasilkan folder Libraries di dalam {nameModule}











