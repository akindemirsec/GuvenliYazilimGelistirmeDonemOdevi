from django.apps import AppConfig
from django.db.models.signals import post_migrate


def create_groups(sender, **kwargs):
    from django.contrib.auth.models import Group, User

    groups = ['Admin', 'User', 'Guest']
    for group in groups:
        Group.objects.get_or_create(name=group)

    admin_group = Group.objects.get(name='Admin')
    user_group = Group.objects.get(name='User')
    guest_group = Group.objects.get(name='Guest')

    if not User.objects.filter(username='admin').exists():
        admin_user = User.objects.create_user('admin', password='adminpassword')
        admin_user.groups.add(admin_group)

    if not User.objects.filter(username='user').exists():
        user = User.objects.create_user('user', password='userpassword')
        user.groups.add(user_group)

    if not User.objects.filter(username='guest').exists():
        guest = User.objects.create_user('guest', password='guestpassword')
        guest.groups.add(guest_group)


class CoreConfig(AppConfig):
    default_auto_field = "django.db.models.BigAutoField"
    name = "core"
