from django.contrib.auth import authenticate, login
from django.contrib.auth.mixins import LoginRequiredMixin
from django.shortcuts import render, redirect
from django.views import View
from django.http import JsonResponse
from .models import Item

class LoginView(View):
    def get(self, request):
        return render(request, 'login.html')

    def post(self, request):
        username = request.POST['username']
        password = request.POST['password']
        user = authenticate(request, username=username, password=password)
        if user is not None:
            login(request, user)
            return redirect('home')
        else:
            return render(request, 'login.html', {'error': 'Invalid credentials'})

class HomeView(LoginRequiredMixin, View):
    login_url = '/login/'
    def get(self, request):
        return render(request, 'home.html')

class SecureView(LoginRequiredMixin, View):
    login_url = '/login/'
    def get(self, request):
        return render(request, 'secure.html')

class ItemListView(LoginRequiredMixin, View):
    login_url = '/login/'
    def get(self, request):
        return render(request, 'item_list.html')

class ItemCreateView(LoginRequiredMixin, View):
    login_url = '/login/'
    def get(self, request):
        return render(request, 'item_form.html', {'item': {}})

    def post(self, request):
        name = request.POST['name']
        description = request.POST['description']
        Item.objects.create(name=name, description=description)
        return redirect('item_list')

class ItemUpdateView(LoginRequiredMixin, View):
    login_url = '/login/'
    def get(self, request, pk):
        item = Item.objects.get(pk=pk)
        return render(request, 'item_form.html', {'item': item})

    def post(self, request, pk):
        item = Item.objects.get(pk=pk)
        item.name = request.POST['name']
        item.description = request.POST['description']
        item.save()
        return redirect('item_list')

class ItemDeleteView(LoginRequiredMixin, View):
    login_url = '/login/'
    def get(self, request, pk):
        item = Item.objects.get(pk=pk)
        item.delete()
        return redirect('item_list')

class ItemAjaxListView(View):
    def get(self, request):
        items = Item.objects.all().values()
        return JsonResponse(list(items), safe=False)
