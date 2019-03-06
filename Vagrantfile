# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  config.vm.box = "ubuntu/xenial64"
  config.vm.box_url = "https://vagrantcloud.com/ubuntu/xenial64"

  # Standard HTTP port
  config.vm.network :forwarded_port, guest: 80, host: 5466

   #config.vm.network :private_network, ip: "192.168.2.101"
   config.vm.network :private_network, ip: "192.168.56.111"
#   config.vm.network :public_network

  # Rsync-based folder share
  config.vm.synced_folder "./website", "/opt/website"#,
    #type: "rsync",
    #owner: "root",
    #group: "root",
    #rsync__auto: "true",
    #rsync__exclude: ".git",
    #rsync__args: ["--verbose", "--archive", "-z"],
    #rsync__chown: false

  # Enable SSH agent forwarding.
  config.ssh.forward_agent = true

  # Provisioning script
  config.vm.provision :shell, :path => "vm-config/provision.sh"

    config.vm.provider "virtualbox" do |v|
        v.memory = 4096
        v.cpus = 2
    end

end
