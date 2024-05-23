from django.core.management.base import BaseCommand
from django.contrib.auth.models import Group, User

class Command(BaseCommand):
    help = 'Create initial groups and users'

    def handle(self, *args, **kwargs):
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

        self.stdout.write(self.style.SUCCESS('Successfully created groups and users'))
