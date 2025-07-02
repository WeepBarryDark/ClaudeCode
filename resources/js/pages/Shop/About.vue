<template>
  <ShopLayout :categories="categories">
    <div class="bg-white">
      <!-- Hero Section -->
      <section class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">About Ecos Flooring</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
              For over 20 years, we've been providing premium flooring solutions to homes and businesses. 
              Our commitment to quality, sustainability, and customer satisfaction has made us a trusted leader in the industry.
            </p>
          </div>
        </div>
      </section>

      <!-- Our Story Section -->
      <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
              <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Story</h2>
              <div class="space-y-4 text-gray-600">
                <p>
                  Founded in 2003, Ecos Flooring began as a small family business with a simple mission: 
                  to provide beautiful, sustainable flooring options that enhance every space they grace.
                </p>
                <p>
                  What started in a modest warehouse has grown into a comprehensive flooring destination, 
                  serving thousands of satisfied customers across the region. We've maintained our family values 
                  while expanding our expertise and product offerings.
                </p>
                <p>
                  Today, we're proud to offer an extensive selection of hardwood, luxury vinyl, laminate, 
                  tile, carpet, and bamboo flooring options, along with professional installation services 
                  and ongoing support.
                </p>
              </div>
            </div>
            <div class="bg-gray-200 rounded-lg h-64 flex items-center justify-center">
              <span class="text-gray-500">Company Photo</span>
            </div>
          </div>
        </div>
      </section>

      <!-- Values Section -->
      <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Values</h2>
            <p class="text-lg text-gray-600">The principles that guide everything we do</p>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
              <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-2xl">🌱</span>
              </div>
              <h3 class="text-xl font-semibold mb-2">Sustainability</h3>
              <p class="text-gray-600">
                We're committed to eco-friendly practices and sustainable materials 
                that protect our planet for future generations.
              </p>
            </div>
            
            <div class="text-center">
              <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-2xl">⭐</span>
              </div>
              <h3 class="text-xl font-semibold mb-2">Quality</h3>
              <p class="text-gray-600">
                Every product we sell meets our rigorous quality standards, 
                ensuring durability and beauty that lasts for years.
              </p>
            </div>
            
            <div class="text-center">
              <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-2xl">🤝</span>
              </div>
              <h3 class="text-xl font-semibold mb-2">Service</h3>
              <p class="text-gray-600">
                Our expert team provides personalized guidance and professional 
                installation to ensure your complete satisfaction.
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- Team Section -->
      <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Meet Our Team</h2>
            <p class="text-lg text-gray-600">Experienced professionals dedicated to your flooring needs</p>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
              <div class="w-32 h-32 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                <span class="text-gray-500">Photo</span>
              </div>
              <h3 class="text-xl font-semibold mb-1">Sarah Johnson</h3>
              <p class="text-green-600 mb-2">Founder & CEO</p>
              <p class="text-gray-600 text-sm">
                20+ years in flooring industry, passionate about sustainable design
              </p>
            </div>
            
            <div class="text-center">
              <div class="w-32 h-32 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                <span class="text-gray-500">Photo</span>
              </div>
              <h3 class="text-xl font-semibold mb-1">Mike Chen</h3>
              <p class="text-green-600 mb-2">Installation Manager</p>
              <p class="text-gray-600 text-sm">
                Master craftsman with expertise in all flooring types
              </p>
            </div>
            
            <div class="text-center">
              <div class="w-32 h-32 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                <span class="text-gray-500">Photo</span>
              </div>
              <h3 class="text-xl font-semibold mb-1">Emily Rodriguez</h3>
              <p class="text-green-600 mb-2">Design Consultant</p>
              <p class="text-gray-600 text-sm">
                Interior design specialist helping customers find perfect matches
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- CTA Section -->
      <section class="py-16 bg-green-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h2 class="text-3xl font-bold mb-4">Ready to Transform Your Space?</h2>
          <p class="text-xl text-green-100 mb-8 max-w-2xl mx-auto">
            Let our experts help you find the perfect flooring solution for your home or business.
          </p>
          <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <Link :href="route('contact')" class="bg-white text-green-600 px-8 py-3 rounded-lg font-semibold hover:bg-green-50 transition-colors">
              Get Free Consultation
            </Link>
            <Link :href="route('samples')" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-green-600 transition-colors">
              Order Free Samples
            </Link>
          </div>
        </div>
      </section>
    </div>
  </ShopLayout>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import ShopLayout from '@/layouts/ShopLayout.vue'

interface Category {
  id: number
  name: string
  slug: string
  description?: string
  image?: string
}

interface Props {
  categories: Category[]
}

defineProps<Props>()
</script>