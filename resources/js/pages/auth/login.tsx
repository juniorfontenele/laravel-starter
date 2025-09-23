import { ThemeToggle } from '@/components/ThemeToggle';
import { Button } from '@/components/ui/button';
import { store } from '@/routes/login';
import { Tenant } from '@/types';
import { Form, Head, usePage } from '@inertiajs/react';
import { useState } from 'react';
import { AiOutlineEye, AiOutlineEyeInvisible } from 'react-icons/ai';

interface LoginProps {
    canResetPassword?: boolean;
    status?: string;
}

export default function Login({ canResetPassword = false, status }: LoginProps) {
    const [showPassword, setShowPassword] = useState(false);
    const { tenant, errors } = usePage<{ tenant: Tenant }>().props;

    return (
        <>
            <Head title="Entrar" />
            <div className="bg-page flex h-dvh min-h-dvh items-center justify-center p-4">
                <div className="w-full max-w-sm">
                    <div className="bg-surface rounded-radius p-8 shadow-lg">
                        {/* Logo Placeholder */}
                        <div className="mb-8 text-center">
                            <img src={tenant.logo} alt="Laravel Starter" className="mx-auto h-12 w-auto" />
                            <div className="text-muted text-sm">{tenant.title}</div>
                        </div>

                        {/* Título */}
                        <h1 className="text-text mb-8 text-center text-2xl font-semibold">Entrar</h1>

                        {/* Status Message */}
                        {status && <div className="text-success mb-4 text-sm">{status}</div>}

                        {/* Form */}
                        <Form method="post" action={store()} className="space-y-6">
                            {/* Email Field */}
                            <div>
                                <label htmlFor="email" className="text-text mb-2 block text-sm font-medium">
                                    Email
                                </label>
                                <input id="email" name="email" type="email" autoComplete="email" required className="input" />
                                {errors.email && <div className="text-error mt-1 text-sm">{errors.email}</div>}
                            </div>

                            {/* Password Field */}
                            <div>
                                <label htmlFor="password" className="text-text mb-2 block text-sm font-medium">
                                    Senha
                                </label>
                                <div className="relative">
                                    <input
                                        id="password"
                                        name="password"
                                        type={showPassword ? 'text' : 'password'}
                                        autoComplete="current-password"
                                        required
                                        className="input pr-12"
                                    />
                                    <button
                                        type="button"
                                        className="absolute inset-y-0 right-0 flex items-center pr-3"
                                        onClick={() => setShowPassword(!showPassword)}
                                    >
                                        <div className="text-muted h-5 w-5">
                                            {showPassword ? <AiOutlineEyeInvisible className="h-5 w-5" /> : <AiOutlineEye className="h-5 w-5" />}
                                        </div>
                                    </button>
                                </div>
                            </div>

                            {/* Forgot Password Link */}
                            {canResetPassword && (
                                <div className="text-center">
                                    <a href="/forgot-password" className="text-primary text-sm hover:underline">
                                        Esqueci minha senha
                                    </a>
                                </div>
                            )}

                            {/* Login Button */}
                            <Button type="submit" className="w-full">
                                Entrar
                            </Button>
                        </Form>

                        {/* Passwordless Login */}
                        {/* <div className="mt-4">
                            <button
                                type="button"
                                className="btn border-border text-text w-full border bg-transparent hover:bg-neutral-50 dark:hover:bg-neutral-800"
                            >
                                Login sem senha
                            </button>
                        </div> */}

                        {/* Social Login Separator */}
                        {/* <div className="mt-6 mb-6">
                            <div className="text-muted text-center text-sm">Ou acesse com</div>
                        </div> */}

                        {/* Social Login Buttons */}
                        {/* <div className="grid grid-cols-2 gap-3">
                            <Button variant="outline" className="social-btn-google">
                                <FaGoogle className="h-5 w-5" />
                            </Button>

                            <Button variant="outline" className="social-btn-facebook">
                                <FaFacebook className="h-5 w-5" />
                            </Button>
                        </div> */}
                    </div>
                </div>

                {/* Theme Toggle - Fixed Position */}
                <div className="fixed top-4 right-4 z-50">
                    <ThemeToggle />
                </div>
            </div>
        </>
    );
}
