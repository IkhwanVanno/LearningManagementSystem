import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // CSS Files
                "resources/css/welcome.css",
                "resources/css/auth.css",
                "resources/css/profile.css",
                "resources/css/layout.css",
                "resources/css/sidebar.css",
                "resources/css/main.css",
                "resources/css/toast.css",

                // Admin CSS Files
                "resources/css/admin/dashboard.css",
                "resources/css/admin/users.css",
                "resources/css/admin/kelas.css",
                "resources/css/admin/master.css",
                "resources/css/admin/monitoring.css",

                // Mentor CSS Files
                "resources/css/mentor/dashboard.css",
                "resources/css/mentor/kelas.css",
                "resources/css/mentor/kelas-detail.css",
                "resources/css/mentor/murid.css",
                "resources/css/mentor/materi.css",
                "resources/css/mentor/tugas.css",
                "resources/css/mentor/tugas-edit.css",
                "resources/css/mentor/penilaian.css",

                // Student CSS Files
                "resources/css/student/dashboard.css",
                "resources/css/student/kelas.css",
                "resources/css/student/kelas-detail.css",
                "resources/css/student/materi.css",
                "resources/css/student/tugas.css",
                "resources/css/student/tugas-kerjakan.css",
                "resources/css/student/penilaian.css",
                "resources/css/student/penilaian-detail.css",

                // JavaScript Files
                "resources/js/welcome.js",
                "resources/js/toast.js",

                // Admin JavaScript Files
                "resources/js/admin/dashboard.js",
                "resources/js/admin/users.js",
                "resources/js/admin/kelas.js",
                "resources/js/admin/master.js",
                "resources/js/admin/monitoring.js",

                // Mentor JavaScript Files
                "resources/js/mentor/dashboard.js",
                "resources/js/mentor/kelas.js",
                "resources/js/mentor/kelas-detail.js",
                "resources/js/mentor/murid.js",
                "resources/js/mentor/materi.js",
                "resources/js/mentor/tugas.js",
                "resources/js/mentor/tugas-edit.js",
                "resources/js/mentor/penilaian.js",

                // Student JavaScript Files
                "resources/js/student/dashboard.js",
                "resources/js/student/kelas.js",
                "resources/js/student/kelas-detail.js",
                "resources/js/student/materi.js",
                "resources/js/student/penilaian.js",
                "resources/js/student/tugas.js",
                "resources/js/student/tugas-kerjakan.js",
            ],
            refresh: true,
        }),
    ],
});
