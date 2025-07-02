<template>
  <ShopLayout :categories="categories">
    <div class="bg-white">
      <!-- Header -->
      <section class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Contact Us</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
              Have questions about our flooring options? Need expert advice? 
              We're here to help you find the perfect solution for your space.
            </p>
          </div>
        </div>
      </section>

      <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Information -->
            <div>
              <h2 class="text-2xl font-bold text-gray-900 mb-6">Get in Touch</h2>
              
              <div class="space-y-6">
                <div class="flex items-start space-x-4">
                  <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mt-1">
                    <span class="text-green-600">📍</span>
                  </div>
                  <div>
                    <h3 class="font-semibold text-gray-900">Visit Our Showroom</h3>
                    <p class="text-gray-600">
                      123 Flooring Street<br>
                      Design District<br>
                      Your City, ST 12345
                    </p>
                  </div>
                </div>
                
                <div class="flex items-start space-x-4">
                  <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mt-1">
                    <span class="text-green-600">📞</span>
                  </div>
                  <div>
                    <h3 class="font-semibold text-gray-900">Call Us</h3>
                    <p class="text-gray-600">
                      <a href="tel:555-123-4567" class="hover:text-green-600">(555) 123-4567</a><br>
                      <a href="tel:555-123-4568" class="hover:text-green-600">(555) 123-4568</a> (Installation)
                    </p>
                  </div>
                </div>
                
                <div class="flex items-start space-x-4">
                  <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mt-1">
                    <span class="text-green-600">✉️</span>
                  </div>
                  <div>
                    <h3 class="font-semibold text-gray-900">Email Us</h3>
                    <p class="text-gray-600">
                      <a href="mailto:info@ecosflooring.com" class="hover:text-green-600">info@ecosflooring.com</a><br>
                      <a href="mailto:sales@ecosflooring.com" class="hover:text-green-600">sales@ecosflooring.com</a>
                    </p>
                  </div>
                </div>
                
                <div class="flex items-start space-x-4">
                  <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mt-1">
                    <span class="text-green-600">🕒</span>
                  </div>
                  <div>
                    <h3 class="font-semibold text-gray-900">Business Hours</h3>
                    <p class="text-gray-600">
                      Monday - Friday: 8:00 AM - 6:00 PM<br>
                      Saturday: 9:00 AM - 4:00 PM<br>
                      Sunday: Closed
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-gray-50 rounded-lg p-8">
              <h2 class="text-2xl font-bold text-gray-900 mb-6">Send us a Message</h2>
              
              <form @submit.prevent="submitForm" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                    <input
                      v-model="form.name"
                      type="text"
                      id="name"
                      required
                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent"
                    />
                  </div>
                  
                  <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input
                      v-model="form.email"
                      type="email"
                      id="email"
                      required
                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent"
                    />
                  </div>
                </div>
                
                <div>
                  <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                  <input
                    v-model="form.phone"
                    type="tel"
                    id="phone"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent"
                  />
                </div>
                
                <div>
                  <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                  <select
                    v-model="form.category"
                    id="category"
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent"
                  >
                    <option value="">Select a category</option>
                    <option value="general">General Inquiry</option>
                    <option value="product_inquiry">Product Information</option>
                    <option value="sample_request">Sample Request</option>
                    <option value="installation">Installation Services</option>
                    <option value="warranty">Warranty Claim</option>
                    <option value="complaint">Complaint</option>
                  </select>
                </div>
                
                <div>
                  <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject *</label>
                  <input
                    v-model="form.subject"
                    type="text"
                    id="subject"
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent"
                  />
                </div>
                
                <div>
                  <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message *</label>
                  <textarea
                    v-model="form.message"
                    id="message"
                    rows="5"
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent"
                  ></textarea>
                </div>
                
                <button
                  type="submit"
                  :disabled="submitting"
                  class="w-full bg-green-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                >
                  <span v-if="!submitting">Send Message</span>
                  <span v-else>Sending...</span>
                </button>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>
  </ShopLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import ShopLayout from '@/layouts/ShopLayout.vue'

interface Category {
  id: number
  name: string
  slug: string
}

interface Props {
  categories: Category[]
}

defineProps<Props>()

const form = ref({
  name: '',
  email: '',
  phone: '',
  category: '',
  subject: '',
  message: ''
})

const submitting = ref(false)

const submitForm = async () => {
  submitting.value = true
  
  try {
    await router.post(route('contact.store'), form.value)
    // Form will redirect on success
  } catch (error) {
    console.error('Failed to submit form:', error)
  } finally {
    submitting.value = false
  }
}
</script>