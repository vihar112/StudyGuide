### Ansible Folder Structure and Overview
Here's a comprehensive folder structure for an Ansible project: \

```
ansible-project/
├── ansible.cfg                 # Configuration file
├── inventory/                  # Host definitions
│   ├── production.yml          # Production environment hosts
│   ├── staging.yml             # Staging environment hosts
│   └── group_vars/             # Variables for groups
│       ├── all.yml             # Variables for all hosts
│       ├── webservers.yml      # Variables for webserver group
│       └── dbservers.yml       # Variables for database group
├── host_vars/                  # Host-specific variables
│   ├── web1.example.com.yml    # Variables for specific host
│   └── db1.example.com.yml     # Variables for specific host
├── roles/                      # Reusable roles
│   ├── common/                 # Common role for all servers
│   │   ├── defaults/           # Default variables
│   │   │   └── main.yml
│   │   ├── files/              # Static files
│   │   ├── handlers/           # Handlers
│   │   │   └── main.yml
│   │   ├── meta/               # Role metadata
│   │   │   └── main.yml
│   │   ├── tasks/              # Tasks
│   │   │   └── main.yml
│   │   ├── templates/          # Jinja2 templates
│   │   └── vars/               # Role variables
│   │       └── main.yml
│   ├── webserver/              # Role for web servers
│   └── database/               # Role for database servers
├── playbooks/                  # Playbooks directory
│   ├── site.yml                # Main playbook
│   ├── webservers.yml          # Playbook for webservers
│   └── dbservers.yml           # Playbook for database servers
└── library/                    # Custom modules

```
#### Key Files and Their Purpose

#### Configuration Files

 **ansible.cfg:** The main configuration file that defines Ansible behavior, paths, plugins, etc.

#### Inventory Files

**inventory/production.yml, inventory/staging.yml:** Define hosts and groups for different environments  \
**group_vars/all.yml:**  Variables that apply to all hosts  \
**group_vars/webservers.yml:** Variables specific to webserver hosts  \
**host_vars/web1.example.com.yml:** Variables specific to a single host  \

#### Roles
A role is a reusable collection of tasks, handlers, files, templates, and variables:  \

**defaults/main.yml:** Default variables for the role (lowest precedence)  \
**files/:**  Static files to be copied to hosts
**handlers/main.yml:** Handler definitions (actions triggered by notify statements)  \
**meta/main.yml:** Role metadata including dependencies  \
**tasks/main.yml:** The main list of tasks the role executes  \
**templates/: Jinja2** templates that can be customized before deployment \
**vars/main.yml:** Role variables (higher precedence than defaults)  \

#### Playbooks

 **playbooks/site.yml:** The main playbook that might include others  \
 **playbooks/webservers.yml:** Specific playbook for web server configurations  \
