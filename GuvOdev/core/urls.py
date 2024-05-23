from django.urls import path
from django.contrib.auth.views import LogoutView
from .views import LoginView, HomeView, SecureView, ItemListView, ItemCreateView, ItemUpdateView, ItemDeleteView, ItemAjaxListView

urlpatterns = [
    path('login/', LoginView.as_view(), name='login'),
    path('home/', HomeView.as_view(), name='home'),
    path('secure/', SecureView.as_view(), name='secure'),
    path('items/', ItemListView.as_view(), name='item_list'),
    path('items/create/', ItemCreateView.as_view(), name='item_create'),
    path('items/update/<int:pk>/', ItemUpdateView.as_view(), name='item_update'),
    path('items/delete/<int:pk>/', ItemDeleteView.as_view(), name='item_delete'),
    path('items/ajax/', ItemAjaxListView.as_view(), name='item_list_ajax'),
    path('logout/', LogoutView.as_view(next_page='/login/'), name='logout'),
]
