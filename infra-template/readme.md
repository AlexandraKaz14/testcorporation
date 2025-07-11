# Инфраструктура в коде
Настройка VM происходит при помощи


### Glitchtip
Должен быть доступен по https://glitchtip.testcorporation.ru/

```
Пользователь:
admin@example.com

```

### Grafana
Должен быть доступен по https://grafana.testcorporation.ru/

```
Пользователь:
admin

```

### Ansible

```bash
ansible-playbook -i infra-template/ansible/inventory.ini infra-template/ansible/playbook.yml
```

### Terraform


```bash
terraform init
```

```bash
terraform apply
```
