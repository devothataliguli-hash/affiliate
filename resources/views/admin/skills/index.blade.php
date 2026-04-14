@extends('layouts.admin')

@section('title', 'Skills Management')
@section('page-title', 'Skills & Categories')

@section('content')
<div x-data="skillManager()" x-init="init()" class="space-y-6">

    {{-- Toast Notification --}}
    <div x-show="toast.show" x-transition.duration.300ms
         class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 bg-gray-800 text-white px-5 py-3 rounded-lg shadow-lg flex items-center gap-3 text-sm"
         style="display: none;">
        <i :class="toast.type === 'success' ? 'fas fa-check-circle text-green-400' : 'fas fa-exclamation-triangle text-red-400'"></i>
        <span x-text="toast.message"></span>
        <button @click="toast.show = false" class="text-gray-300 hover:text-white ml-2">&times;</button>
    </div>

    {{-- Tabs --}}
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm">
        <div class="flex">
            <button @click="activeTab = 'add'"
                    :class="activeTab === 'add' ? 'bg-emerald-50 text-emerald-700' : 'text-gray-600 hover:bg-gray-50'"
                    class="flex-1 py-3 px-4 text-sm font-medium border-r border-gray-200 transition">
                <i class="fas fa-plus mr-2"></i> Ingiza Skill Mpya
            </button>
            <button @click="activeTab = 'list'; loadSkills(1)"
                    :class="activeTab === 'list' ? 'bg-emerald-50 text-emerald-700' : 'text-gray-600 hover:bg-gray-50'"
                    class="flex-1 py-3 px-4 text-sm font-medium border-r border-gray-200 transition">
                <i class="fas fa-list mr-2"></i> Orodha ya Skills
            </button>
            <button @click="activeTab = 'categories'; loadCategoriesTab()"
                    :class="activeTab === 'categories' ? 'bg-emerald-50 text-emerald-700' : 'text-gray-600 hover:bg-gray-50'"
                    class="flex-1 py-3 px-4 text-sm font-medium transition">
                <i class="fas fa-tags mr-2"></i> Categories
            </button>
        </div>
    </div>

    {{-- ==================== TAB 1: ADD / EDIT SKILL ==================== --}}
    <div x-show="activeTab === 'add'" x-cloak>
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4" x-text="skillForm.id ? 'Hariri Skill' : 'Taarifa za Skill'"></h3>

            {{-- BUG FIX: use id="skillForm" so we can target it precisely --}}
            <form id="skillForm" @submit.prevent="submitSkillForm" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Category with +New button --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Category *</label>
                        <div class="flex gap-2">
                            <select x-model="skillForm.category_id" required class="flex-1 border rounded-lg px-3 py-2 text-sm">
                                <option value="">-- Chagua Category --</option>
                                <template x-for="cat in categories" :key="cat.id">
                                    <option :value="cat.id" x-text="cat.name"></option>
                                </template>
                            </select>
                            <button type="button" @click="openCategoryModal()"
                                    class="bg-gray-200 hover:bg-gray-300 px-3 rounded-lg text-sm whitespace-nowrap">
                                <i class="fas fa-plus"></i> Mpya
                            </button>
                        </div>
                    </div>

                    {{-- Skill Name --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Jina la Skill *</label>
                        <input type="text" x-model="skillForm.name" required class="w-full border rounded-lg px-3 py-2 text-sm">
                    </div>

                    {{-- Price --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Bei (Tsh) *</label>
                        <input type="number" x-model="skillForm.price" step="0.01" min="0" required class="w-full border rounded-lg px-3 py-2 text-sm">
                    </div>

                    {{-- Description --}}
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Maelezo</label>
                        <textarea x-model="skillForm.description" rows="2" class="w-full border rounded-lg px-3 py-2 text-sm"></textarea>
                    </div>

                    {{-- Platform Link --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Kiungo cha Platform</label>
                        <input type="url" x-model="skillForm.platform_link" class="w-full border rounded-lg px-3 py-2 text-sm" placeholder="https://...">
                    </div>

                    {{-- Video URL --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Video URL</label>
                        <input type="url" x-model="skillForm.video_url" class="w-full border rounded-lg px-3 py-2 text-sm" placeholder="https://...">
                    </div>

                    {{-- Video File --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Faili ya Video</label>
                        <input type="file" id="video_file" name="video_file" accept="video/*" class="w-full text-sm">
                        <p class="text-xs text-gray-400 mt-1">Max 20MB (MP4, MOV, AVI)</p>
                    </div>

                    {{-- PDF File --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Faili ya PDF</label>
                        <input type="file" id="pdf_file" name="pdf_file" accept="application/pdf" class="w-full text-sm">
                        <p class="text-xs text-gray-400 mt-1">Max 10MB</p>
                    </div>

                    {{-- Voice File --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Faili ya Sauti</label>
                        <input type="file" id="voice_file" name="voice_file" accept="audio/*" class="w-full text-sm">
                        <p class="text-xs text-gray-400 mt-1">Max 15MB (MP3, WAV, OGG)</p>
                    </div>

                    {{-- Notes --}}
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Maelezo ya Ziada (HTML inaruhusiwa)</label>
                        <textarea x-model="skillForm.notes" rows="4" class="w-full border rounded-lg px-3 py-2 text-sm font-mono"></textarea>
                    </div>

                    {{-- Active --}}
                    <div>
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" x-model="skillForm.is_active" class="mr-2"> Inayoonekana kwa watumiaji
                        </label>
                    </div>
                </div>

                <div class="mt-6 flex justify-between">
                    <button type="button" x-show="skillForm.id" @click="resetSkillForm()"
                            class="border border-gray-300 hover:bg-gray-50 px-4 py-2 rounded-lg text-sm text-gray-600">
                        <i class="fas fa-times mr-1"></i> Ghairi Uhariri
                    </button>
                    <button type="submit" :disabled="submitting"
                            class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-lg text-sm ml-auto disabled:opacity-50">
                        <i class="fas fa-save mr-1"></i>
                        <span x-text="submitting ? 'Inahifadhi...' : 'Hifadhi Skill'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ==================== TAB 2: SKILLS LIST ==================== --}}
    <div x-show="activeTab === 'list'" x-cloak>
        {{-- Search Bar --}}
        <div class="bg-white p-3 rounded-lg border border-gray-200 shadow-sm mb-4">
            <div class="flex flex-col sm:flex-row gap-2">
                <div class="flex-1 relative">
                    <input type="text" x-model="searchTerm" @input.debounce.300ms="loadSkills(1)"
                           placeholder="Tafuta kwa jina, category..."
                           class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:ring-1 focus:ring-emerald-500">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <div class="flex gap-2">
                    <button @click="printSkills()" class="px-3 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700 text-sm">
                        <i class="fas fa-print mr-1"></i> Print
                    </button>
                </div>
            </div>
        </div>

        {{-- Skills Table --}}
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jina</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bei</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hali</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Vitendo</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <template x-for="skill in skills" :key="skill.id">
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div class="font-medium" x-text="skill.name"></div>
                                    <div class="text-xs text-gray-500" x-text="skill.description ? skill.description.substring(0,50) : ''"></div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="px-2 py-0.5 text-xs rounded-full bg-blue-100 text-blue-800"
                                          x-text="skill.category ? skill.category.name : '-'"></span>
                                </td>
                                <td class="px-4 py-3"
                                    x-text="skill.price == 0 ? 'Bure' : 'Tsh ' + Number(skill.price).toLocaleString()"></td>
                                <td class="px-4 py-3">
                                    <span :class="skill.is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'"
                                          class="px-2 py-0.5 text-xs rounded-full"
                                          x-text="skill.is_active ? 'Inaonekana' : 'Haionekani'"></span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <button @click="editSkill(skill.id)" class="text-blue-600 hover:text-blue-800" title="Hariri">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button @click="confirmDeleteSkill(skill.id)" class="text-red-600 hover:text-red-800" title="Futa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="skills.length === 0 && !loadingSkills">
                            <td colspan="5" class="text-center py-8 text-gray-500">Hakuna skills zilizopatikana</td>
                        </tr>
                        <tr x-show="loadingSkills">
                            <td colspan="5" class="text-center py-8 text-gray-400">
                                <i class="fas fa-spinner fa-spin mr-2"></i> Inapakia...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {{-- Pagination --}}
            <div class="px-4 py-3 border-t" x-html="paginationHtml"></div>
        </div>
    </div>

    {{-- ==================== TAB 3: CATEGORIES LIST ==================== --}}
    <div x-show="activeTab === 'categories'" x-cloak>
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="flex items-center justify-between p-4 border-b">
                <h3 class="font-semibold text-gray-700">Orodha ya Categories</h3>
                <button @click="openCategoryModal()" class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-emerald-700">
                    <i class="fas fa-plus mr-1"></i> Ongeza Category
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jina</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Maelezo</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hali</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Vitendo</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <template x-for="cat in categoriesAll" :key="cat.id">
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium" x-text="cat.name"></td>
                                <td class="px-4 py-3 text-sm text-gray-500" x-text="cat.description || '-'"></td>
                                <td class="px-4 py-3">
                                    <span :class="cat.is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'"
                                          class="px-2 py-0.5 text-xs rounded-full"
                                          x-text="cat.is_active ? 'Inayoonekana' : 'Haionekani'"></span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <button @click="openCategoryModal(cat)" class="text-blue-600 hover:text-blue-800" title="Hariri">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button @click="confirmDeleteCategory(cat.id)" class="text-red-600 hover:text-red-800" title="Futa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="categoriesAll.length === 0">
                            <td colspan="4" class="text-center py-8 text-gray-500">Hakuna categories</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ==================== MODAL: ADD/EDIT CATEGORY ==================== --}}
    <div x-show="categoryModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-500 opacity-75" @click="categoryModalOpen = false"></div>
            <div class="relative bg-white rounded-lg max-w-md w-full p-6 shadow-xl">
                <h3 class="text-lg font-semibold mb-4" x-text="categoryModalTitle"></h3>
                <div>
                    <div class="mb-3">
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Jina la Category *</label>
                        <input type="text" x-model="categoryForm.name" required
                               placeholder="Jina la Category"
                               class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-emerald-500">
                    </div>
                    <div class="mb-3">
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Maelezo</label>
                        <textarea x-model="categoryForm.description" rows="2"
                                  placeholder="Maelezo (si lazima)"
                                  class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-emerald-500"></textarea>
                    </div>
                    <label class="flex items-center mb-4 cursor-pointer">
                        <input type="checkbox" x-model="categoryForm.is_active" class="mr-2"> Inayoonekana
                    </label>
                    <div class="flex justify-end space-x-3">
                        <button type="button" @click="categoryModalOpen = false"
                                class="px-4 py-2 border rounded-lg text-sm hover:bg-gray-50">Ghairi</button>
                        <button type="button" @click="submitCategoryForm()" :disabled="submittingCategory"
                                class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-emerald-700 disabled:opacity-50">
                            <span x-text="submittingCategory ? 'Inahifadhi...' : 'Hifadhi'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ==================== MODAL: DELETE CATEGORY CONFIRM ==================== --}}
    <div x-show="deleteCategoryModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-500 opacity-75" @click="deleteCategoryModalOpen = false"></div>
            <div class="relative bg-white rounded-lg max-w-md w-full p-6 shadow-xl">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center mr-3">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold">Thibitisha Kufuta Category</h3>
                </div>
                <p class="text-gray-600 text-sm mb-6">Je, una uhakika unataka kufuta category hii? Skills zitakuwa bila category.</p>
                <div class="flex justify-end space-x-3">
                    <button @click="deleteCategoryModalOpen = false"
                            class="px-4 py-2 border rounded-lg text-sm hover:bg-gray-50">Ghairi</button>
                    <button @click="deleteCategory()" :disabled="submittingCategory"
                            class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700 disabled:opacity-50">
                        <span x-text="submittingCategory ? 'Inafuta...' : 'Futa'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ==================== MODAL: DELETE SKILL CONFIRM ==================== --}}
    <div x-show="deleteSkillModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-500 opacity-75" @click="deleteSkillModalOpen = false"></div>
            <div class="relative bg-white rounded-lg max-w-md w-full p-6 shadow-xl">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center mr-3">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold">Thibitisha Kufuta Skill</h3>
                </div>
                <p class="text-gray-600 text-sm mb-6">Je, una uhakika unataka kufuta skill hii? Hatua hii haiwezi kutenduliwa.</p>
                <div class="flex justify-end space-x-3">
                    <button @click="deleteSkillModalOpen = false"
                            class="px-4 py-2 border rounded-lg text-sm hover:bg-gray-50">Ghairi</button>
                    <button @click="deleteSkill()" :disabled="submitting"
                            class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700 disabled:opacity-50">
                        <span x-text="submitting ? 'Inafuta...' : 'Futa'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function skillManager() {
    return {
        // UI state
        activeTab: 'add',
        toast: { show: false, message: '', type: 'success' },
        searchTerm: '',
        submitting: false,
        submittingCategory: false,
        loadingSkills: false,

        // Data
        categories: [],       // for the dropdown (active only)
        categoriesAll: [],    // for the categories tab
        skills: [],
        paginationHtml: '',

        // Skill form
        skillForm: {
            id: null, name: '', category_id: '', description: '', price: 0,
            platform_link: '', video_url: '', notes: '', is_active: true
        },
        deleteSkillId: null,
        deleteSkillModalOpen: false,

        // Category modals
        categoryModalOpen: false,
        deleteCategoryModalOpen: false,
        categoryModalTitle: '',
        categoryForm: { id: null, name: '', description: '', is_active: true },
        deleteCategoryId: null,

        init() {
            this.loadCategories();
            this.loadSkills();
        },

        // ──────────────────────────────────────────────────
        // CATEGORIES
        // ──────────────────────────────────────────────────
        loadCategories() {
            fetch('/admin/categories/all')
                .then(res => res.json())
                .then(data => {
                    this.categories = data;
                    this.categoriesAll = data;
                })
                .catch(() => {
                    this.categories = [];
                    this.showToast('Hitilafu kupakia categories', 'error');
                });
        },

        loadCategoriesTab() {
            this.loadCategories();
        },

        openCategoryModal(category = null) {
            if (category) {
                this.categoryForm = {
                    id: category.id,
                    name: category.name,
                    description: category.description || '',
                    is_active: !!category.is_active
                };
                this.categoryModalTitle = 'Hariri Category';
            } else {
                this.categoryForm = { id: null, name: '', description: '', is_active: true };
                this.categoryModalTitle = 'Ongeza Category Mpya';
            }
            this.categoryModalOpen = true;
        },

        submitCategoryForm() {
            if (!this.categoryForm.name.trim()) {
                this.showToast('Jina la category linahitajika', 'error');
                return;
            }
            this.submittingCategory = true;

            const isEdit = !!this.categoryForm.id;
            // BUG FIX: PUT must be sent as POST with _method override for Laravel
            const url = isEdit
                ? `/admin/categories/${this.categoryForm.id}`
                : '/admin/categories';

            const payload = {
                _method: isEdit ? 'PUT' : 'POST',
                name: this.categoryForm.name,
                description: this.categoryForm.description,
                is_active: this.categoryForm.is_active ? 1 : 0,  // BUG FIX: send 1/0, not bool
            };

            fetch(url, {
                method: 'POST',   // BUG FIX: always POST; Laravel reads _method
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(payload),
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.showToast(isEdit ? 'Category imerekebishwa' : 'Category imeongezwa');
                    this.loadCategories();
                    this.categoryModalOpen = false;
                } else {
                    const msg = data.errors
                        ? Object.values(data.errors).flat().join(', ')
                        : (data.message || 'Hitilafu imetokea');
                    this.showToast(msg, 'error');
                }
            })
            .catch(() => this.showToast('Hitilafu ya mtandao', 'error'))
            .finally(() => this.submittingCategory = false);
        },

        confirmDeleteCategory(id) {
            this.deleteCategoryId = id;
            this.deleteCategoryModalOpen = true;
        },

        deleteCategory() {
            this.submittingCategory = true;
            fetch(`/admin/categories/${this.deleteCategoryId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.showToast('Category imefutwa');
                    this.loadCategories();
                } else {
                    this.showToast(data.message || 'Hitilafu wakati wa kufuta', 'error');
                }
                this.deleteCategoryModalOpen = false;
            })
            .catch(() => this.showToast('Hitilafu ya mtandao', 'error'))
            .finally(() => this.submittingCategory = false);
        },

        // ──────────────────────────────────────────────────
        // SKILLS
        // ──────────────────────────────────────────────────
        loadSkills(page = 1) {
            this.loadingSkills = true;
            let url = `/admin/skills-json?page=${page}`;
            if (this.searchTerm) url += `&search=${encodeURIComponent(this.searchTerm)}`;
            fetch(url, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                this.skills = data.data || [];
                this.paginationHtml = this.renderPagination(data);
            })
            .catch(() => this.showToast('Hitilafu kupakia skills', 'error'))
            .finally(() => this.loadingSkills = false);
        },

        renderPagination(data) {
            if (!data.last_page || data.last_page <= 1) return '';
            let html = '<div class="flex justify-center flex-wrap gap-1">';
            for (let i = 1; i <= data.last_page; i++) {
                const active = i === data.current_page
                    ? 'bg-emerald-600 text-white'
                    : 'bg-gray-200 hover:bg-gray-300 text-gray-700';
                html += `<button onclick="Alpine.evaluate(document.querySelector('[x-data]'), 'loadSkills(${i})')"
                                 class="px-3 py-1 rounded text-sm ${active}">${i}</button>`;
            }
            html += '</div>';
            return html;
        },

        // BUG FIX: Build FormData manually so Alpine x-model values are included
        submitSkillForm() {
            if (!this.skillForm.name.trim()) {
                this.showToast('Jina la skill linahitajika', 'error');
                return;
            }
            if (!this.skillForm.category_id) {
                this.showToast('Chagua category', 'error');
                return;
            }

            this.submitting = true;
            const isEdit = !!this.skillForm.id;
            const url = isEdit ? `/admin/skills/${this.skillForm.id}` : '/admin/skills';

            // BUG FIX: Build FormData from Alpine state (not from DOM form),
            // then attach file inputs separately
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            if (isEdit) formData.append('_method', 'PUT');   // BUG FIX: only append once

            formData.append('name',          this.skillForm.name);
            formData.append('category_id',   this.skillForm.category_id);
            formData.append('description',   this.skillForm.description || '');
            formData.append('price',         this.skillForm.price);
            formData.append('platform_link', this.skillForm.platform_link || '');
            formData.append('video_url',     this.skillForm.video_url || '');
            formData.append('notes',         this.skillForm.notes || '');
            // BUG FIX: checkboxes don't submit when unchecked; always append explicitly
            formData.append('is_active',     this.skillForm.is_active ? '1' : '0');

            // Attach files if selected
            const videoFile = document.getElementById('video_file');
            const pdfFile   = document.getElementById('pdf_file');
            const voiceFile = document.getElementById('voice_file');
            if (videoFile && videoFile.files[0]) formData.append('video_file', videoFile.files[0]);
            if (pdfFile   && pdfFile.files[0])   formData.append('pdf_file',   pdfFile.files[0]);
            if (voiceFile && voiceFile.files[0]) formData.append('voice_file', voiceFile.files[0]);

            fetch(url, {
                method: 'POST',   // always POST; Laravel reads _method for PUT
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    // NOTE: Do NOT set Content-Type here — browser sets it with boundary for multipart
                },
            })
            .then(res => {
                if (!res.ok) return res.json().then(err => Promise.reject(err));
                return res.json();
            })
            .then(data => {
                if (data.success) {
                    this.showToast(isEdit ? 'Skill imerekebishwa!' : 'Skill imeongezwa!');
                    this.resetSkillForm();
                    this.loadSkills();
                    this.activeTab = 'list';
                } else {
                    const msg = data.errors
                        ? Object.values(data.errors).flat().join(', ')
                        : (data.message || 'Hitilafu imetokea');
                    this.showToast(msg, 'error');
                }
            })
            .catch(error => {
                const msg = error && error.errors
                    ? Object.values(error.errors).flat().join(', ')
                    : (error && error.message ? error.message : 'Hitilafu ya mtandao');
                this.showToast(msg, 'error');
            })
            .finally(() => this.submitting = false);
        },

        editSkill(id) {
            fetch(`/admin/skills/${id}/edit-json`, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => {
                if (!res.ok) throw new Error('Skill haikupatikana');
                return res.json();
            })
            .then(skill => {
                this.skillForm = {
                    id:            skill.id,
                    name:          skill.name,
                    category_id:   skill.category_id,
                    description:   skill.description || '',
                    price:         skill.price,
                    platform_link: skill.platform_link || '',
                    video_url:     skill.video_url || '',
                    notes:         skill.notes || '',
                    is_active:     !!skill.is_active,
                };
                // Clear file inputs
                ['video_file', 'pdf_file', 'voice_file'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.value = '';
                });
                this.activeTab = 'add';
                window.scrollTo({ top: 0, behavior: 'smooth' });
            })
            .catch(err => this.showToast(err.message || 'Hitilafu kupakia skill', 'error'));
        },

        resetSkillForm() {
            this.skillForm = {
                id: null, name: '', category_id: '', description: '', price: 0,
                platform_link: '', video_url: '', notes: '', is_active: true,
            };
            ['video_file', 'pdf_file', 'voice_file'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.value = '';
            });
        },

        confirmDeleteSkill(id) {
            this.deleteSkillId = id;
            this.deleteSkillModalOpen = true;
        },

        deleteSkill() {
            this.submitting = true;
            fetch(`/admin/skills/${this.deleteSkillId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.showToast('Skill imefutwa');
                    this.loadSkills();
                } else {
                    this.showToast(data.message || 'Hitilafu wakati wa kufuta', 'error');
                }
                this.deleteSkillModalOpen = false;
            })
            .catch(() => this.showToast('Hitilafu ya mtandao', 'error'))
            .finally(() => this.submitting = false);
        },

        // ──────────────────────────────────────────────────
        // HELPERS
        // ──────────────────────────────────────────────────
        showToast(message, type = 'success') {
            this.toast.message = message;
            this.toast.type    = type;
            this.toast.show    = true;
            setTimeout(() => this.toast.show = false, 5000);
        },

        printSkills() {
            let tableRows = '';
            this.skills.forEach(skill => {
                tableRows += `<tr>
                    <td style="border:1px solid #ddd;padding:8px;">${skill.name}</td>
                    <td style="border:1px solid #ddd;padding:8px;">${skill.category ? skill.category.name : '-'}</td>
                    <td style="border:1px solid #ddd;padding:8px;">${skill.price == 0 ? 'Bure' : 'Tsh ' + Number(skill.price).toLocaleString()}</td>
                    <td style="border:1px solid #ddd;padding:8px;">${skill.is_active ? 'Inaonekana' : 'Haionekani'}</td>
                </tr>`;
            });
            const w = window.open('', '_blank');
            w.document.write(`<!DOCTYPE html><html><head><title>Orodha ya Skills</title>
                <style>body{font-family:Arial;margin:20px;}table{width:100%;border-collapse:collapse;}
                th,td{border:1px solid #ddd;padding:8px;text-align:left;}th{background:#f3f4f6;}</style>
                </head><body>
                <h2>Orodha ya Skills</h2><p>${new Date().toLocaleDateString()}</p>
                <table><thead><tr><th>Jina</th><th>Category</th><th>Bei</th><th>Hali</th></tr></thead>
                <tbody>${tableRows}</tbody></table></body></html>`);
            w.document.close();
            w.print();
        },
    };
}
</script>
@endsection