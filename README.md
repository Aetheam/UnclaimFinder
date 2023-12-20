[![Discord](https://img.shields.io/discord/915046808009441323.svg?label=&logo=discord&logoColor=ffffff&color=7389D8&labelColor=6A7EC2)](https://discord.gg/AzJ7Uz7wkx)

# Unclaim Finder
A plugin that helps you to find tile entities in specific world.

## How to use
Configure the item ID, permissions, worlds, blocks, and format in the `config.yml` file. 

(permission is now starting with `unclaimfinder` + `yourpermissionname`

## Config
```yaml
item: "iron_nugget"
permission:
  enabled: false
  name: "unclaimfinder.use"
worlds: # Leave empty if you want the unclaimed finder to work on all worlds.
  - "world"
blocks: # Only tile entities
  - "chest"
  - "barrel"
  - "furnace"
  - "shulker_box"
  - "ender_chest"
format: "§a{count} §b%"
