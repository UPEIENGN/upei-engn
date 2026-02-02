import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
    can: boolean;
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    auth: Auth;
    ziggy: Config & { location: string };
    flash: { success: string; error: string; };
};

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    is_admin: boolean;
    created_at: string;
    updated_at: string;
}

export type BreadcrumbItemType = BreadcrumbItem;

export interface Can {
    create: boolean;
    update: boolean;
    delete: boolean;
}
export interface Society {
    id: number;
    name: string;
    description: string;
    email: string;
    facebook_url: string;
    instagram_handle: string;
    twitter_handle: string;
    discord_url: string;
    meeting_schedule: string;
    meeting_location: string;
    created_at: string;
    updated_at: string;
    deleted_at: string;
}

export interface SocietyMember {
    id: number;
    society_id: number;
    name: string;
    email: string;
    role: number;
    role_label: string;
    title: string;
    description: string;
    renewed_at: string;
    is_expired: boolean;
    image: File;
    created_at: string;
    updated_at: string;
    deleted_at: string;
}

export interface Event {
    id: number;
    society_id: number;
    title: string;
    description: string;
    location: string;
    start: string;
    end: string;
    created_at: string;
    updated_at: string;
    deleted_at: string;
}

export interface Product {
    id: number;
    society_id: number;
    name: string;
    description: string;
    price: number;
    stock: number;
    colors: string[];
    sizes: string[];
    images: File[];
    created_at: string;
    updated_at: string;
    deleted_at: string;
}

export interface Order {
    id: number;
    society_id: number;
    cart_id: number;
    name: string;
    email: string;
    address: string;
    created_at: string;
    updated_at: string;
    deleted_at: string;
}

export interface File {
    id: number;
    name: string;
    original_name: string;
    path: string;
    disk: string;
    size: number;
    fileable_id: number;
    fileable_type: string;
    url: string;
    created_at: string;
    updated_at: string;
    deleted_at: string;
}

export interface Cart {
    id: number;
    items: CartItem[];
    session_id: string;
    created_at: string;
    updated_at: string;
}

export interface CartItem {
    id: number;
    cart_id: number;
    product_id: number;
    product: Product;
    quantity: number;
    color: string;
    size: string;
    created_at: string;
    updated_at: string;
}

export interface Pagination<T> {
    current_page: number;
    data: Array<T>;
    first_page_url: string;
    from: number;
    last_page: number;
    last_page_url: string;
    links: Array<PaginationLink>;
    next_page_url: string;
    path: string;
    per_page: number;
    prev_page_url: string;
    to: number;
    total: number;
}

export interface PaginationLink {
    url: string;
    label: string;
    active: boolean;
}

export interface CalendarEntry {
    date: string;
    isCurrentMonth: boolean;
    isToday: boolean;
    events: Event[];
}
