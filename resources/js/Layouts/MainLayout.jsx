import React from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function MainLayout({ children }) {
    const { auth } = usePage().props;

    return (
        <div className="flex flex-col min-h-screen bg-gray-50 text-gray-800">
            {/* Header */}
            <header className="bg-white shadow">
                <div className="container mx-auto px-4 py-4 flex justify-between items-center">
                    <Link href="/" className="text-2xl font-bold text-blue-600">🎧 Musicify</Link>
                    <nav className="flex items-center gap-4">
                        <Link href="/" className="hover:text-blue-600">Главная</Link>
                        {auth.user && (
                            <>
                                <Link href="/tracks" className="hover:text-blue-600">Мои треки</Link>
                                <Link href="/playlists" className="hover:text-blue-600">Плейлисты</Link>
                                <Link href="/profile" className="hover:text-blue-600">Профиль</Link>
                            </>
                        )}
                        {!auth.user ? (
                            <>
                                <Link href="/login" className="hover:text-blue-600">Войти</Link>
                                <Link href="/register" className="hover:text-blue-600">Регистрация</Link>
                            </>
                        ) : (
                            <Link href="/logout" method="post" as="button" className="text-red-600">Выйти</Link>
                        )}
                    </nav>
                </div>
            </header>

            {/* Main Content */}
            <main className="flex-1 container mx-auto px-4 py-8">
                {children}
            </main>

            {/* Footer */}
            <footer className="bg-white shadow mt-10">
                <div className="container mx-auto px-4 py-6 flex flex-col md:flex-row justify-between items-center text-sm text-gray-600">
                    <div>&copy; {new Date().getFullYear()} Musicify. Все права защищены.</div>
                    <div className="flex gap-4 mt-2 md:mt-0">
                        <Link href="/about" className="hover:text-blue-600">О нас</Link>
                        <Link href="/policy" className="hover:text-blue-600">Политика конфиденциальности</Link>
                        <Link href="/contacts" className="hover:text-blue-600">Контакты</Link>
                    </div>
                </div>
            </footer>
        </div>
    );
}
