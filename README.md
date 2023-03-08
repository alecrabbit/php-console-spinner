# DAM 🦫 aka dev-app-makefile
The set of Makefiles spiced with shell scripts to make development easier

> WIP


```bash
wget -qO- "https://github.com/alecrabbit/dev-app-makefile/archive/refs/tags/0.0.11.tar.gz" \
| tar -xz && shopt -s dotglob && cp -rv dev-app-makefile-0.0.11/* . \
&& shopt -u dotglob && rm -r dev-app-makefile-0.0.11 && ./install
```

```bash
wget -qO- "https://github.com/alecrabbit/dev-app-makefile/archive/refs/heads/main.tar.gz" \
| tar -xz && shopt -s dotglob && cp -rv dev-app-makefile-main/* . \
&& shopt -u dotglob && rm -r dev-app-makefile-main && ./install && make upgrade c=main
```

```bash
wget -qO- "https://github.com/alecrabbit/dev-app-makefile/archive/refs/heads/dev.tar.gz" \
| tar -xz && shopt -s dotglob && cp -rv dev-app-makefile-dev/* . \
&& shopt -u dotglob && rm -r dev-app-makefile-dev && ./install && make upgrade c=dev
```

