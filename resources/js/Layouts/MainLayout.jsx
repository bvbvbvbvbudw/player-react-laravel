import React, { useState, useEffect, useRef } from 'react';
import { Link, usePage, router } from '@inertiajs/react';

export default function MainLayout({ children }) {
    const { auth } = usePage().props;
    const [query, setQuery] = useState('');
    const [results, setResults] = useState({ tracks: [], playlists: [], users: [] });
    const [showDropdown, setShowDropdown] = useState(false);
    const inputRef = useRef();

    // Функция для запроса результатов (например, GET /search?q=...)
    const fetchResults = async (q) => {
        if (!q) {
            setResults({ tracks: [], playlists: [], users: [] });
            setShowDropdown(false);
            return;
        }

        try {
            const response = await fetch(`/search?q=${encodeURIComponent(q)}`);
            if (!response.ok) throw new Error('Ошибка поиска');
            const data = await response.json();
            setResults(data);
            setShowDropdown(true);
        } catch (error) {
            console.error(error);
            setResults({ tracks: [], playlists: [], users: [] });
            setShowDropdown(false);
        }
    };

    // Делаем запрос при изменении query с небольшой задержкой (debounce)
    useEffect(() => {
        const handler = setTimeout(() => {
            fetchResults(query);
        }, 300);

        return () => clearTimeout(handler);
    }, [query]);

    // Обработка отправки формы (Enter или кнопка)
    const onSubmit = (e) => {
        e.preventDefault();
        setShowDropdown(false);
        if (query.trim()) {
            router.visit(`/search-results?q=${encodeURIComponent(query.trim())}`);
        }
    };

    useEffect(() => {
        const handleClickOutside = (event) => {
            if (inputRef.current && !inputRef.current.contains(event.target)) {
                setShowDropdown(false);
            }
        };
        document.addEventListener('mousedown', handleClickOutside);
        return () => document.removeEventListener('mousedown', handleClickOutside);
    }, []);

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
                                <Link href="/my-tracks" className="hover:text-blue-600">Мои треки</Link>
                                <Link href="/my-playlists" className="hover:text-blue-600">Плейлисты</Link>
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

                    {/* Поисковая форма */}
                    <div className="relative ml-6" ref={inputRef}>
                        <form onSubmit={onSubmit}>
                            <input
                                type="text"
                                value={query}
                                onChange={e => setQuery(e.target.value)}
                                placeholder="Поиск треков, плейлистов, пользователей..."
                                className="border rounded px-3 py-1 w-72 focus:outline-none focus:ring focus:border-blue-300"
                                autoComplete="off"
                            />
                        </form>

                        {/* Выпадающий список результатов */}
                        {showDropdown && (
                            <div className="absolute z-50 mt-1 w-full bg-white border rounded shadow max-h-60 overflow-auto">
                                {/* Треки */}
                                {results.tracks.length > 0 && (
                                    <div className="p-2 border-b">
                                        <div className="font-semibold mb-1">Треки</div>
                                        {results.tracks.map(track => (
                                            <Link
                                                key={track.id}
                                                href={`/tracks/${track.id}`}
                                                className="block px-2 py-1 hover:bg-blue-100"
                                                onClick={() => setShowDropdown(false)}
                                            >
                                                {track.title} — {track.artist}
                                            </Link>
                                        ))}
                                    </div>
                                )}

                                {/* Плейлисты */}
                                {results.playlists.length > 0 && (
                                    <div className="p-2 border-b">
                                        <div className="font-semibold mb-1">Плейлисты</div>
                                        {results.playlists.map(pl => (
                                            <Link
                                                key={pl.id}
                                                href={`/playlists/${pl.id}`}
                                                className="block px-2 py-1 hover:bg-blue-100"
                                                onClick={() => setShowDropdown(false)}
                                            >
                                                {pl.name} (создатель: {pl.user?.name ?? "null"})
                                            </Link>
                                        ))}
                                    </div>
                                )}

                                {/* Пользователи */}
                                {results.users.length > 0 && (
                                    <div className="p-2">
                                        <div className="font-semibold mb-1">Пользователи</div>
                                        {results.users.map(user => (
                                            <Link
                                                key={user.id}
                                                href={`/users/${user.id}`}
                                                className="block px-2 py-1 hover:bg-blue-100"
                                                onClick={() => setShowDropdown(false)}
                                            >
                                                {user.name}
                                            </Link>
                                        ))}
                                    </div>
                                )}

                                {/* Если нет результатов */}
                                {results.tracks.length === 0 &&
                                    results.playlists.length === 0 &&
                                    results.users.length === 0 && (
                                        <div className="p-2 text-gray-500">Ничего не найдено</div>
                                    )}
                            </div>
                        )}
                    </div>
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
